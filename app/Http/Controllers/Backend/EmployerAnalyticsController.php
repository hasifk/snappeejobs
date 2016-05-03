<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Job\Job;
use App\Repositories\Backend\Analytics\EmployerAnalyticsRepository;
use App\Repositories\Backend\Dashboard\DashboardRepository;
use App\Repositories\Frontend\Job\EloquentJobRepository;
use \Illuminate\Http\Request;
use DB;

/**
 * Class DashboardController
 * @package App\Http\Controllers\Backend
 */
class EmployerAnalyticsController extends Controller {

    /**
     * @var DashboardRepository
     */
    private $repository;
    private $jobRepository;
    private $dashboard;

    /**
     * DashboardController constructor.
     * @param DashboardRepository $repository
     */
    public function __construct(EmployerAnalyticsRepository $repository, EloquentJobRepository $jobRepository,
DashboardRepository $dashboard) {

        $this->repository = $repository;
        $this->jobRepository = $jobRepository;
        $this->dashboard=$dashboard;
    }

    /**
     * @return \Illuminate\View\View
     */

    public function interestedjobsanalytics(Request $request) {
        if (access()->hasRoles(array('Employer', 'Employer Staff'))) {

            $interested_jobs = Job::join('like_jobs', 'like_jobs.job_id', '=', 'jobs.id')
                            ->join('users', 'users.id', '=', 'like_jobs.user_id')
                            ->join('job_seeker_details', 'job_seeker_details.user_id', '=', 'users.id')
                            ->select([
                                'jobs.*',
                                'job_seeker_details.id',
                                'users.name',
                                \DB::raw('users.id AS userid'),
                            ])->paginate(config('jobs.default_per_page'));
            $view = [
                'interested_jobs' => $interested_jobs,
            ];
            return view('backend.employeranalytics.emp_analytics_intjobs', $view);
        }
    }

    /*     ********************************************************************************************************** */

    public function notinterestedjobsanalytics(Request $request) {

        if (access()->hasRoles(array('Employer', 'Employer Staff'))) {
            $jobsResult = $this->jobRepository->getJobsPaginated($request, config('jobs.default_per_page'));

            $paginator = $jobsResult['paginator'];
            $not_interested_jobs = $jobsResult['jobs'];
            $view = [
                'not_interested_jobs' => $not_interested_jobs,
                'paginator' => $paginator
            ];
            return view('backend.employeranalytics.emp_analytics_nt_intjobs', $view);
        }
    }


    /*     ********************************************************************************************************** */

    public function companyVisitors(Request $request) {

        if (access()->hasRoles(array('Employer', 'Employer Staff'))) {
            $company_visitors = $this->repository->getTotalCmpVisitors($request);
            $view = [
                'company_visitors' => $company_visitors,
            ];
            return view('backend.employeranalytics.emp_analytics_cmp_visitors', $view);
        }
    }

    /*     ********************************************************************************************************** */

    public function companyAuthVisitors(Request $request) {

        if (access()->hasRoles(array('Employer', 'Employer Staff'))) {
            $company_auth_visitors = $this->repository->getTotalAuthCmpVisitors();

            $view = [
                'company_auth_visitors' => $company_auth_visitors,
            ];
            return view('backend.employeranalytics.emp_analytics_authcmp_visitors', $view);
        }
    }

    /*     ********************************************************************************************************** */

    public function jobVisitors(Request $request) {

        if (access()->hasRoles(array('Employer', 'Employer Staff'))) {
            $job_visitors = $this->repository->getTotalJobVisitors();

            $view = [
                'job_visitors' => $job_visitors,
            ];
            return view('backend.employeranalytics.emp_analytics_job_visitors', $view);
        }
    }

    /*     ********************************************************************************************************** */

    public function jobAuthVisitors(Request $request) {

        if (access()->hasRoles(array('Employer', 'Employer Staff'))) {
            $job_auth_visitors = $this->repository->getTotalAuthJobVisitors();

            $view = [
                'job_auth_visitors' => $job_auth_visitors,
            ];
            return view('backend.employeranalytics.emp_analytics_authjob_visitors', $view);
        }
    }

    /*     ********************************************************************************************************** */

    public function UniqueJobVisitors(Request $request) {
        if (access()->hasRoles(array('Employer', 'Employer Staff'))) {
            $job_unique_visitors = $this->repository->getUniqueJobVisitors();

            $view = [
                'job_unique_visitors' => $job_unique_visitors
            ];
            return view('backend.employeranalytics.emp_analytics_unq_job_visitors', $view);
        }
    }

    /*     ********************************************************************************************************** */

    public function UniqueCompanyVisitors(Request $request) {
        if (access()->hasRoles(array('Employer', 'Employer Staff'))) {
            $company_unique_visitors = $this->repository->getUniqueCompanyVisitors();

            $view = [
                'company_unique_visitors' => $company_unique_visitors
            ];
            return view('backend.employeranalytics.emp_analytics_unq_cmp_visitors', $view);
        }
    }

    /*     ********************************************************************************************************** */
    public function companyInterestMap(Request $request) {
        if (access()->hasRoles(array('Employer', 'Employer Staff'))) {
            $view['cmp_interest_map_info'] = $this->dashboard->getCompanyInterestMapInfo();
            $view['latlong'] =$this->dashboard->getLatLong();

            return view('backend.employeranalytics.company_interest_map', $view);
        }
    }

    /*     ********************************************************************************************************** */
}
