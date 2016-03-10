<?php namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Access\User\User;
use App\Repositories\Backend\Dashboard\DashboardRepository;
use App\Repositories\Backend\Mail\EloquentMailRepository;
use Carbon\Carbon;
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

        if ( access()->hasRoles(['Employer', 'Employer Staff']) ) {
            $view['total_jobs_posted']  = $this->repository->getTotalJobsPostedCount();
            $view['total_job_application']  = $this->repository->getTotalJobsApplicationsCount();
            $view['total_staff_members']  = $this->repository->getTotalStaffMembersCount();
            $view['new_messages']  = $this->repository->getTotalNewMessagesCount();
            $view['visitors']  = $this->repository->getTotalVisitorsCount();
            $view['active_job_listings1']  = $this->repository->getActiveJobListingCount1();
            $view['thumbs_ups']  = $this->repository->getThumbsUpsCount();
            $view['employer_notifications'] = $this->repository->getEmployerNotifications();
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

    public function unread_messages(EloquentMailRepository $mailRepository){
        $unread_messages = $mailRepository->getUnReadMessages();
        return response()->json($mailRepository->unReadMessages);
    }

    public function job_applications(Request $request){
        $jobApplications = \DB::table('job_applications')
            ->join('jobs', 'jobs.id', '=', 'job_applications.job_id')
            ->join('users', 'job_applications.user_id', '=', 'users.id')
            ->where('jobs.company_id', auth()->user()->companyId )
            ->where(function($query){
                $query->whereNull('job_applications.accepted_at' )
                    ->whereNull('job_applications.declined_at');
            })
            ->select([
                'job_applications.id',
                'jobs.title',
                'users.name',
                \DB::raw('users.id AS user_id'),
                'job_applications.created_at'
            ])
            ->get();

        if ( $jobApplications ) {
            foreach ($jobApplications as $key => $jobApplication) {
                $jobApplications[$key]->{'image'} = User::find($jobApplication->user_id)->picture;
                $jobApplications[$key]->{'was_created'} = Carbon::parse($jobApplication->created_at)->diffForHumans();
            }
        }

        return response()->json($jobApplications);
    }
/*************************************************************************************************************/
    public function employersearch(Request $request)
    {
        if ( access()->hasRole('Employer') ) {
            $query = $request->input('emp_search_key');
            if(!empty($query)):
            $jobtitle= DB::table('jobs')->where('title', 'LIKE', '%' . $query . '%')
                ->where('company_id', auth()->user()->company_id)->paginate(10);
                $staffinfo= DB::table('users')->where('name', 'LIKE', '%' . $query . '%')->paginate(10)
                    ->where('employer_id', auth()->user()->employer_id);



                $company_id=auth()->user()->company_id;
                $job_cat_info= DB::table('job_categories')
                    ->join('category_preferences_jobs', 'category_preferences_jobs.job_category_id','=','job_categories.id')
                    ->join('jobs', function ($join) use ($company_id) {
                        $join->on('jobs.id', '=', 'category_preferences_jobs.job_id')
                            ->where('jobs.company_id', '=', auth()->user()->company_id);
                    })
                    ->where('job_categories.name', 'LIKE', '%' . $query . '%')
                    ->select([
                        'jobs.title',
                        'job_categories.name'
                    ])->get();
                $search_results = [
                    'jobtitle'         =>  $jobtitle,
                    'staffinfo'            =>$staffinfo,
                    'job_cat_info'=> $job_cat_info
                ];
                return view('backend.emp_search_results',$search_results);


                else:
                    return back();
                    endif;
        }
    }
/************************************************************************************************************/

}
