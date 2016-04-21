<?php

namespace App\Http\Controllers\Frontend\Job;

use App\Models\Job\Job;
use App\Models\JobSeeker\JobSeeker;
use App\Repositories\Backend\Logs\LogsActivitysRepository;
use App\Repositories\Frontend\Job\EloquentJobRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;

use DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Activity;
class JobsController extends Controller
{
    /**
     * @var EloquentJobRepository
     */
    private $jobRepository;
    private $userLogs;
    /**
     * JobsController constructor.
     * @param EloquentJobRepository $jobRepository
     */
    public function __construct(EloquentJobRepository $jobRepository,LogsActivitysRepository $userLogs)
    {
        $this->jobRepository = $jobRepository;
        $this->userLogs = $userLogs;
    }

    public function index(Request $request){

        $companies = \DB::table('companies')->select(['id', 'title'])->get();
        $job_categories = \DB::table('job_categories')->select(['id', 'name'])->get();
        $countries = \DB::table('countries')->select(['id', 'name'])->get();
        $skills = \DB::table('skills')->select(['id', 'name'])->get();

        if ( request('country_id') ) {
            $states = \DB::table('states')
                ->where('country_id', request('country_id'))
                ->select(['id', 'name'])
                ->get();
        } else {
            $states = \DB::table('states')
                ->where('country_id', 222)
                ->select(['id', 'name'])
                ->get();
        }

        $jobsResult = $this->jobRepository->getJobsPaginated( $request, config('jobs.default_per_page'));

        $paginator = $jobsResult['paginator'];
        $jobs = $jobsResult['jobs'];

        $view = [
            'countries'         => $countries,
            'states'            => $states,
            'companies'        => $companies,
            'categories'        => $job_categories,
            'skills'            => $skills,
            'jobs'              => $jobs,
            'paginator'         => $paginator
        ];

        return view('frontend.jobs.index', $view);
    }

    public function show($company, $slug,Request $request){

        $job_id = \DB::table('jobs')
            ->join('companies', 'companies.id', '=', 'jobs.company_id')
            ->where('jobs.title_url_slug', $slug)
            ->where('companies.url_slug', $company)
            ->value('jobs.id');

        $job = Job::find($job_id);

        if (!Session::get('job_visitor-info-stored')):

            $current_ip = $request->ip();
            $visits = $this->jobRepository->storeJobvisits($job_id, $current_ip);


            if(!empty($visits)):
                Session::put('job_visitor-info-stored', true);
                Session::save();
            else:
                return redirect(route('jobs.search'));
            endif;

        endif;

        $view = [
            'job' => $job
        ];

        return view('frontend.jobs.show', $view);

    }

    public function next($jobId){
        $slugs = \DB::table('jobs')
            ->join('companies', 'companies.id', '=', 'jobs.company_id')
            ->where('jobs.id', '<>', $jobId)
            ->orderByRaw('RAND()')
            ->first(['jobs.title_url_slug', 'companies.url_slug']);
        return redirect(route('jobs.view', [$slugs->url_slug, $slugs->title_url_slug]));
    }

    public function likeJob(Request $request)
    {

        $jobId = $request->get('jobId');
        $jobName=Job::where('id',$jobId)->pluck('title');
        $array['type'] = 'JobSeeker';
        $array['heading']='with Name:'.auth()->user()->name.' liked'.$jobName;


        if (! \DB::table('like_jobs')->where('job_id', $jobId)->where('user_id', auth()->user()->id)->count() ) {
            \DB::table('like_jobs')->insert([
                'job_id'    => $jobId,
                'user_id'   => auth()->user()->id,
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()
            ]);
            \DB::table('jobs')
                ->where('id',$jobId)
                ->increment('likes');
        }

        $likes = \DB::table('jobs')
            ->where('id',$jobId)
            ->value('likes');


        $array['event'] = 'liked';
        $name = $this->userLogs->getActivityDescriptionForEvent($array);
        Activity::log($name);

        return json_encode(['status'=>1,'likes'=>$likes]);

    }

    public function applyJob(Requests\Frontend\Job\ApplyJob $request){
        $status = $this->jobRepository->applyJob(auth()->user(), Job::findOrFail($request->get('jobId')));
        $jobName=Job::where('id',$request->get('jobId'))->pluck('title');
        $array['type'] = 'JobSeeker';
        $array['heading']='with Name:'.auth()->user()->name.' applied for'.$jobName;
        $array['event'] = 'applied';

        $name = $this->userLogs->getActivityDescriptionForEvent($array);
        Activity::log($name);
        return json_encode( [ 'status' => $status ] );
    }

    public function matchedJobs(Requests\Frontend\Job\ShowMatchedJobsRequest $request){

        $jobseeker_category_preferences = [];
        $jobseeker_skill_preferences = '';
        // Get the job seeker's preferences
        if (  auth()->user() && (!empty(auth()->user()->job_seeker_details)) ) {
            $jobseeker = JobSeeker::find(auth()->user()->job_seeker_details->id);
            $jobseeker_category_preferences = $jobseeker->categories->lists('id')->toArray();
            $jobseeker_skill_preferences = $jobseeker->skills->lists('id')->toArray();
        }

        if ( $jobseeker_category_preferences ) {
            $request->merge([ 'categories' => $jobseeker_category_preferences ]);
        }

        if ( $jobseeker_skill_preferences ) {
            $request->merge([ 'skills' => $jobseeker_skill_preferences]);
        }

        $jobsResult = $this->jobRepository->getJobsPaginated($request, config('jobs.default_per_page'));

        $jobs = $jobsResult['jobs'];

        $jobs = $jobs->filter(function($job) use ( $request ) {
            return $job->id != $request->get('jobId');
        });

        $view = view('frontend.jobs.matchedjobs', ['jobs' => $jobs])->render();

        $jobs_count = count($jobs);

        return response()->json(['view' => $view, 'jobs' => $jobs, 'jobs_count' => $jobs_count]);

    }


}
