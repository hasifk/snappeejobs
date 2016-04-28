<?php

namespace App\Http\Controllers\Frontend\JobSeekers;

use App\Models\Access\User\User;
use App\Models\JobSeeker\JobSeeker;
use App\Repositories\Frontend\JobSeeker\EloquentJobSeekerRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class JobSeekerController extends Controller
{
    /**
     * @var EloquentJobSeekerRepository
     */
    private $repository;

    /**
     * JobSeekerController constructor.
     * @param EloquentJobSeekerRepository $repository
     */
    public function __construct(EloquentJobSeekerRepository $repository)
    {

        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $countries = \DB::table('countries')->select(['id', 'name'])->get();
        $skills = \DB::table('skills')->select(['id', 'name'])->get();
        $job_categories = \DB::table('job_categories')->select(['id', 'name'])->get();

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

        $jobSeekerResult = $this->repository->getJobsSeekersPaginated($request, config('jobs.default_per_page'));

        $jobSeekers = $jobSeekerResult['jobseekers'];
        $paginator = $jobSeekerResult['paginator'];

        $view = [
            'countries'         => $countries,
            'states'            => $states,
            'skills'            => $skills,
            'categories'        => $job_categories,
            'job_seekers'       => $jobSeekers,
            'paginator'         => $paginator
        ];

        return view('frontend.jobseekers.index', $view);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $jobSeeker = JobSeeker::findOrFail($id);
        $jobSeekerUser = User::find($jobSeeker->user_id);

        return view('frontend.jobseekers.show', [ 'jobseeker' => $jobSeeker, 'jobseeker_user' => $jobSeekerUser ]);
    }

    public function likeJob(Request $request){

        $id = $request->get('jobSeekerId');

        if (! \DB::table('like_jobseekers')->where('jobseeker_id', $id)->where('user_id', auth()->user()->id)->count() ) {
            \DB::table('like_jobseekers')->insert([
                'jobseeker_id'      => $id,
                'user_id'           => auth()->user()->id,
                'created_at'        => Carbon::now(),
                'updated_at'        => Carbon::now()
            ]);
            \DB::table('job_seeker_details')
                ->where('id',$id)
                ->increment('likes');
        }

        $likes = \DB::table('job_seeker_details')
            ->where('id',$id)
            ->value('likes');

        return json_encode(['status'=>1,'likes'=>$likes]);
    }

    public function appliedJobs(){
        $applied =$this->repository->getAppliedJobs();
        return view('frontend.jobseekers.applied_jobs' . ( env('APP_DESIGN') == 'new' ? 'new' : "" ),['applied'	=> $applied ]);
    }

}
