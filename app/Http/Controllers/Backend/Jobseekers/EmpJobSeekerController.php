<?php

namespace App\Http\Controllers\Backend\Jobseekers;

use App\Models\Access\User\User;
use App\Models\JobSeeker\JobSeeker;
use App\Repositories\Backend\JobSeeker\EloquentJobSeekerRepository;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class EmpJobSeekerController extends Controller
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

    public function index(Request $request){

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

        return view('backend.empjobseekers.index', $view);
    }

    public function show($id)
    {
        $jobSeeker = JobSeeker::findOrFail($id);
        $jobSeekerUser = User::find($jobSeeker->user_id);

        return view('backend.empjobseekers.show', [ 'jobseeker' => $jobSeeker, 'jobseeker_user' => $jobSeekerUser ]);
    }
}
