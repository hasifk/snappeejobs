<?php

namespace App\Http\Controllers\Frontend\Job;

use App\Models\Job\Job;
use App\Repositories\Frontend\Job\EloquentJobRepository;
use Illuminate\Http\Request;

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

}
