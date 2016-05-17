<?php namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;

use App\Http\Requests\Backend\Blogs\MakeBlogApprovedRequest;
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
    private $role;
    /**
     * DashboardController constructor.
     * @param DashboardRepository $repository
     */
    public function __construct(LogsActivitysRepository $userLogs,
EloquentBloggerRepository $repository,RoleRepositoryContract $role)
    {

        $this->repository = $repository;
        $this->role = $role;
    }

    /**
     * @return \Illuminate\View\View
     */



    public function createBlogger(Request $request)
    {
        if ( access()->hasRole('Administrator') ) {
            $users=$this->repository->getUsers();
            $view = [
                'users'              => $users,
            ];
            return view('backend.bloggers.create_blogger',$view);

        }
    }
    /************************************************************************************************************/
    public function storeBlogger(Request $request)
    {
        if ( access()->hasRole('Administrator') ) {
            $user=User::find($request->blogger_id);
            $user->attachRoles(array(5));
            return redirect()->route('backend.dashboard')->withFlashSuccess(trans("alerts.blogger.created"));

        }
    }
    /************************************************************************************************************/
    public function availableBloggers(Request $request)
    {
        if ( access()->hasRole('Administrator') ) {
            $bloggers= $this->repository->getUsers();

            $view = [
                'bloggers' => $bloggers,
            ];

            return view('backend.bloggers.bloggers', $view);
        }

    }
    /************************************************************************************************************/

    public function approveBlogs(Request $request)
    {
        if ( access()->hasRole('Administrator') ) {
            $blogs= $this->repository->getBlogs();

            $view = [
                'blogs' => $blogs,
            ];

            return view('backend.bloggers.blogs_to_approve', $view);
        }

    }
    /************************************************************************************************************/
    public function storeApproval(Request $request)
    {
        if ( access()->hasRole('Administrator') ) {
          $this->repository->storeApproval($request);



            return back()->withFlashSuccess('Your Blog approval status updated successfully.');;
        }

    }
    /************************************************************************************************************/




}
