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

    public function index(){

        $jobs = $this->jobRepository->getJobsPaginated(config('jobs.default_per_page'));



        

        $view = ['jobs' => $jobs];

        return view('frontend.jobs.index', $view);
    }

}
