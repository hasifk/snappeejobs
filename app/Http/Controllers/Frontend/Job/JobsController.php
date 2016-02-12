<?php

namespace App\Http\Controllers\Frontend\Job;

use App\Models\Job\Job;
use App\Repositories\Frontend\Job\EloquentJobRepository;
use Illuminate\Http\Request;

use DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class JobsController extends Controller
{
    /**
     * @var EloquentJobRepository
     */
    private $jobRepository;

    /**
     * JobsController constructor.
     * @param EloquentJobRepository $jobRepository
     */
    public function __construct(EloquentJobRepository $jobRepository)
    {
        $this->jobRepository = $jobRepository;
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

    public function show(Requests\Frontend\Job\JobViewRequest $request, $company, $slug){

        $job = Job::with(['company' => function($query) use ($company) {
            $query->where('companies.url_slug', $company);
        }, 'categories', 'skills', 'country', 'state'])
            ->where('title_url_slug', $slug)
            ->first();

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

        return json_encode(['status'=>1,'likes'=>$likes]);

    }

    public function applyJob(Requests\Frontend\Job\ApplyJob $request){
        $status = $this->jobRepository->applyJob(auth()->user(), Job::findOrFail($request->get('jobId')));

        return json_encode( [ 'status' => $status ] );
    }

}
