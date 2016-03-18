<?php namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Access\User\User;
use App\Models\Job\Job;
use App\Models\JobSeeker\JobSeeker;
use App\Repositories\Backend\Dashboard\DashboardRepository;
use App\Repositories\Backend\Job\EloquentSearchJobRepository;
use App\Repositories\Backend\JobSeeker\EloquentSearchJobSeekerRepository;
use App\Repositories\Backend\Mail\EloquentMailRepository;
use App\Repositories\Frontend\Job\EloquentJobRepository;
use App\Repositories\Frontend\JobSeeker\EloquentJobSeekerRepository;
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
    private $searchJobRepo;

    /**
     * DashboardController constructor.
     * @param DashboardRepository $repository
     */
    public function __construct(DashboardRepository $repository,EloquentSearchJobRepository $searchJobRepo,EloquentSearchJobSeekerRepository $searchJobSeekerRepo,
                                EloquentJobRepository $jobRepository)
    {

        $this->repository = $repository;
        $this->jobRepository = $jobRepository;
        $this->searchJobRepo = $searchJobRepo;
        $this->searchJobSeekerRepo = $searchJobSeekerRepo;
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
            $view['company_visitors']  = $this->repository->getTotalCmpVisitorsCount();
            $view['job_visitors']  = $this->repository->getTotalJobVisitorsCount();
            $view['active_job_listings1']  = $this->repository->getActiveJobListingCount1();
            $view['thumbs_ups']  = $this->repository->getThumbsUpsCount();
            $view['employer_notifications'] = $this->repository->getEmployerNotifications();
            $view['cmp_interest_map_info']  = $this->repository->getCompanyInterestMapInfo();
            $view['job_interest_level']  = $this->repository->getJobInterestLevel();

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

                $jobsResult = $this->searchJobRepo->getJobsPaginated( $request,$query, config('jobs.default_per_page'));

                $paginator = $jobsResult['paginator'];
                $jobtitle= $jobsResult['jobtitle'];


                $candidateResult = $this->searchJobSeekerRepo->getJobsSeekersPaginated( $request,$query, config('jobs.default_per_page'));

                $paginator1 = $candidateResult['paginator'];
                $candidate_info= $candidateResult['candidate_info'];

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
                    'job_cat_info'=> $job_cat_info,
                    'paginator'         => $paginator,
                    'candidate_info'  =>$candidate_info,
                    'paginator1'         => $paginator1,
                ];
                $request->flash();
                return view('backend.emp_search_results',$search_results);


                else:
                    return back();
                    endif;
        }
    }
    /************************************************************************************************************/
    public function showstaffmembers(Request $request,$id)
    {
        if ( access()->hasRole('Employer') ) {
            $staff_in_detail=User::find($id);
            $view = [
                'staff_in_detail'              => $staff_in_detail
            ];
            return view('frontend.user.profile.employer_staff_show',$view);

        }
    }
/************************************************************************************************************/
    public function interestedjobsanalytics(Request $request)
    {
        if ( access()->hasRole('Employer','Employer Staff') ) {

            $interested_jobs=Job::join('like_jobs','like_jobs.job_id','=','jobs.id')
                ->join('users','users.id','=','like_jobs.user_id')
                ->join('job_seeker_details','job_seeker_details.user_id','=','users.id')
                ->select([
                    'jobs.*',
                    'job_seeker_details.id',
                    'users.name',
                    \DB::raw('users.id AS userid'),
                ])->paginate(config('jobs.default_per_page'));
            $view = [
                'interested_jobs'              => $interested_jobs,
            ];
                return view('backend.emp_analytics_intjobs',$view);

        }
    }
    /************************************************************************************************************/
    public function notinterestedjobsanalytics(Request $request)
    {
        if ( access()->hasRole('Employer','Employer Staff') ) {
            $jobsResult = $this->jobRepository->getJobsPaginated( $request, config('jobs.default_per_page'));

            $paginator = $jobsResult['paginator'];
            $not_interested_jobs = $jobsResult['jobs'];
            $view = [
                'not_interested_jobs'              => $not_interested_jobs,
                'paginator'         => $paginator
            ];
            return view('backend.emp_analytics_nt_intjobs',$view);

        }
    }
    /************************************************************************************************************/
    public function companyVisitors(Request $request)
    {
        if ( access()->hasRole('Employer','Employer Staff') ) {
            $company_visitors =$this->repository->getTotalCmpVisitors();
            $company_auth_visitors =$this->repository->getTotalAuthCmpVisitors();

            $view = [
                'company_visitors'              => $company_visitors,
                'company_auth_visitors'         => $company_auth_visitors,
            ];
            return view('backend.emp_analytics_cmp_visitors',$view);

        }
    }
    /************************************************************************************************************/
    public function jobVisitors(Request $request)
    {
        if ( access()->hasRole('Employer','Employer Staff') ) {
            $job_visitors =$this->repository->getTotalJobVisitors();
            $job_auth_visitors =$this->repository->getTotalAuthJobVisitors();

            $view = [
                'job_visitors'              => $job_visitors,
                'job_auth_visitors'         => $job_auth_visitors,
            ];
            return view('backend.emp_analytics_job_visitors',$view);

        }
    }
    /************************************************************************************************************/



}
