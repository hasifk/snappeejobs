<?php namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Repositories\Backend\Dashboard\DashboardRepository;
use \Illuminate\Http\Request;
use App\Http\Requests\Backend\AdminProfileEditRequest;
use Storage;
use DB;

/**
 * Class DashboardController
 * @package App\Http\Controllers\Backend
 */
class DashboardController extends Controller {
    /**
     * @var DashboardRepository
     */
    private $repository;


    /**
     * DashboardController constructor.
     * @param DashboardRepository $repository
     */
    public function __construct(DashboardRepository $repository)
    {

        $this->repository = $repository;
    }

	/**
	 * @return \Illuminate\View\View
	 */
    public function index()
    {

        $view = [];

        if ( access()->hasRole('Administrator') ) {
            $view['employer_count']  = $this->repository->getEmployerCount();
            $view['active_subscriptions']  = $this->repository->getActiveSubscriptionCount();
            $view['blocked_users']  = $this->repository->getBlockedUsersCount();
            $view['active_job_listings']  = $this->repository->getActiveJobListingCount();
        }

        if ( access()->hasRole('Employer') ) {
            $view['total_jobs_posted']  = $this->repository->getTotalJobsPostedCount();
            $view['total_job_application']  = $this->repository->getTotalJobsApplicationsCount();
            $view['total_staff_members']  = $this->repository->getTotalStaffMembersCount();
            $view['new_messages']  = $this->repository->getTotalNewMessagesCount();
        }

        return view('backend.dashboard', $view);
    }

	public function profile()
	{
        $user = auth()->user();
        $countries = DB::table('countries')->select(['id', 'name'])->get();
        if ( auth()->user()->country_id ) {
            $states = DB::table('states')->where('country_id', auth()->user()->country_id)->select(['id', 'name'])->get();
        } else {
            $states = DB::table('states')->where('country_id', 222)->select(['id', 'name'])->get();
        }
        $data = [
            'user'      => $user,
            'countries' => $countries,
            'states'    => $states
        ];
		return view('backend.profile', $data);
	}

    public function editProfile(AdminProfileEditRequest $request)
    {

        $avatar = $request->file('avatar');

        $update_array = [
            'name'          => $request->get('name'),
            'about_me'      => $request->get('about_me'),
            'country_id'    => $request->get('country_id'),
            'state_id'      => $request->get('state_id'),
        ];

        if ( $avatar && $avatar->isValid() ) {
            
            $filePath = "users/" . auth()->user()->id."/avatar/";
            Storage::put($filePath. $avatar->getClientOriginalName() , file_get_contents($avatar));
            Storage::setVisibility($filePath. $avatar->getClientOriginalName(), 'public');

            if ( auth()->user()->avatar_filename ) {
                Storage::delete(auth()->user()->avatar_path.auth()->user()->avatar_filename.'.'.auth()->user()->avatar_extension);
            }

            $update_array = array_merge($update_array, [
                'avatar_filename' => pathinfo($avatar->getClientOriginalName(), PATHINFO_FILENAME),
                'avatar_extension' => $avatar->getClientOriginalExtension(),
                'avatar_path' => $filePath
            ]);
        }

        if ( $request->get('password') ) {
            $update_array = array_merge($update_array, ['password' => bcrypt($request->get('password'))]);
        }

        auth()->user()->update($update_array);

        return redirect()->route('backend.profile')->withFlashSuccess(trans("alerts.users.profile_updated"));

    }

}