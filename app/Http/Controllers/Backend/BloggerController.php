<?php namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;

use App\Http\Requests\Backend\Employer\SocialFeeds\TwitterInfoRequest;
use App\Models\Access\User\User;
use App\Repositories\Backend\Blogger\EloquentBloggerRepository;
use App\Repositories\Backend\Dashboard\DashboardRepository;
use App\Repositories\Backend\JobSeeker\EloquentJobSeekerRepository;
use App\Repositories\Backend\Logs\LogsActivitysRepository;
use App\Repositories\Backend\Role\RoleRepositoryContract;
use App\Repositories\Backend\SocialFeeds\SocialFeedsRepository;
use App\Repositories\Backend\User\EloquentUserRepository;
use \Illuminate\Http\Request;
use DB;
use Activity;

/**
 * Class BloggerController
 * @package App\Http\Controllers\Backend
 */
class BloggerController extends Controller {
    /**
     * @var DashboardRepository
     */
    private $repository;
    private $jobSeeker;
    private $role;
    /**
     * DashboardController constructor.
     * @param DashboardRepository $repository
     */
    public function __construct(LogsActivitysRepository $userLogs,
EloquentJobSeekerRepository $jobSeeker,EloquentBloggerRepository $repository,RoleRepositoryContract $role)
    {

        $this->jobSeeker = $jobSeeker;
        $this->repository = $repository;
        $this->role = $role;
    }

    /**
     * @return \Illuminate\View\View
     */



    public function createBlogger(Request $request)
    {
        if ( access()->hasRole('Administrator') ) {
            $jobSeekerResult=$this->jobSeeker->getJobsSeekersPaginated($request, config('jobs.default_per_page'));
            $jobSeekers = $jobSeekerResult['jobseekers'];
            $view = [
                'jobSeekers'              => $jobSeekers,
            ];
            return view('backend.bloggers.create_blogger',$view);

        }
    }
    /************************************************************************************************************/
    public function storeBlogger(Request $request)
    {
        if ( access()->hasRole('Administrator') ) {
            $user=User::find($request->blogger_id);
            $user->detachRoles(array(4));
            $user->attachRoles(array(5));
            return redirect()->route('backend.dashboard')->withFlashSuccess(trans("alerts.blogger.created"));

        }
    }
    /************************************************************************************************************/
    public function availableBloggers(Request $request)
    {
        $jobSeekerResult = $this->jobSeeker->getJobsSeekersPaginated($request, config('jobs.default_per_page'));

        $jobSeekers = $jobSeekerResult['jobseekers'];
        $paginator = $jobSeekerResult['paginator'];

        $view = [
            'job_seekers'       => $jobSeekers,
            'paginator'         => $paginator
        ];

        return view('backend.bloggers.bloggers', $view);
    }
    /************************************************************************************************************/





}
