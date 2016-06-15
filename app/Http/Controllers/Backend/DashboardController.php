<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Access\User\User;
use App\Models\Job\Job;
use App\Models\JobSeeker\JobSeeker;
use App\Models\Company\Company;
use App\Models\State\State;
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
    public function __construct(DashboardRepository $repository, EloquentSearchJobRepository $searchJobRepo, EloquentSearchJobSeekerRepository $searchJobSeekerRepo, EloquentJobRepository $jobRepository) {

        $this->repository = $repository;
        $this->jobRepository = $jobRepository;
        $this->searchJobRepo = $searchJobRepo;
        $this->searchJobSeekerRepo = $searchJobSeekerRepo;
    }


    /**
     * @return \Illuminate\View\View
     */
    public function index() {

        $view = [];

        if (access()->hasRole('Administrator')) {
            $view['employer_count'] = $this->repository->getEmployerCount();
            $view['active_subscriptions'] = $this->repository->getActiveSubscriptionCount();
            $view['blocked_users'] = $this->repository->getBlockedUsersCount();
            $view['active_job_listings'] = $this->repository->getActiveJobListingCount();
            $view['job_seeker_count'] = $this->repository->getJobSeekerCount();
        }

        if (access()->hasRoles(['Employer', 'Employer Staff'])) {
            $view['total_jobs_posted'] = $this->repository->getTotalJobsPostedCount();
            $view['total_job_application'] = $this->repository->getTotalJobsApplicationsCount();
            $view['total_staff_members'] = $this->repository->getTotalStaffMembersCount();
            $view['new_messages'] = $this->repository->getTotalNewMessagesCount();
            $view['company_visitors'] = $this->repository->getTotalCmpVisitorsCount();
            $view['job_visitors'] = $this->repository->getTotalJobVisitorsCount();
            $view['active_job_listings1'] = $this->repository->getActiveJobListingCount1();
            $view['thumbs_ups'] = $this->repository->getThumbsUpsCount();
            $view['employer_notifications'] = $this->repository->getEmployerNotifications();
            $view['newsfeed_notifications'] = $this->repository->getNewsfeedNotifications();
            $view['job_visitors_today'] = $this->repository->getTodaysJobVisitorsCount();
            $view['job_interest_level'] = $this->repository->getJobInterestLevel();

        }

        return view('backend.dashboard', $view);
    }

    public function profile() {
        $user = auth()->user();
        $countries = DB::table('countries')->select(['id', 'name'])->get();
        if (auth()->user()->country_id) {
            $states = DB::table('states')->where('country_id', auth()->user()->country_id)->select(['id', 'name'])->get();
        } else {
            $states = DB::table('states')->where('country_id', 222)->select(['id', 'name'])->get();
        }
        $data = [
            'user' => $user,
            'countries' => $countries,
            'states' => $states
        ];
        return view('backend.profile', $data);
    }

    public function notificationsHistory() {

        $data = [
            'notifications' => $this->repository->employerNotifications()
        ];

        return view('backend.notification_history', $data);
    }
/*****************************************************************************************************************/
    public function newsfeedsHistory() {

        $data = [
            'notifications' => $this->repository->newsFeedsNotifications()
        ];

        return view('backend.newsfeed_notification', $data);
    }
/*****************************************************************************************************************/
    public function editProfile(AdminProfileEditRequest $request) {

        $avatar = $request->file('avatar');

        $update_array = [
            'name' => $request->get('name'),
            'about_me' => $request->get('about_me'),
            'country_id' => $request->get('country_id'),
            'state_id' => $request->get('state_id'),
        ];

        if ( $avatar && $avatar->isValid() ) {

            if ( (!empty(auth()->user()->avatar_path)) && \Storage::has(auth()->user()->avatar_path.auth()->user()->avatar_filename.'.'.auth()->user()->avatar_extension) ) {
                \Storage::deleteDirectory(auth()->user()->avatar_path);
            }

            $filePath = "users/" . auth()->user()->id."/avatar/";
            \Storage::put($filePath. $avatar->getClientOriginalName() , file_get_contents($avatar));
            \Storage::setVisibility($filePath. $avatar->getClientOriginalName(), 'public');

            if ( auth()->user()->avatar_filename ) {
                foreach (config('image.thumbnails.user_profile_image') as $image) {
                    if ( \Storage::has($filePath.pathinfo($avatar->getClientOriginalName(), PATHINFO_FILENAME).$image['width'].'x'.$image['height'].'.'.$avatar->getClientOriginalExtension()) ) {
                        \Storage::delete($filePath.pathinfo($avatar->getClientOriginalName(), PATHINFO_FILENAME).$image['width'].'x'.$image['height'].'.'.$avatar->getClientOriginalExtension());
                    }
                }
            }

            $update_array = [
                'avatar_filename' => pathinfo($avatar->getClientOriginalName(), PATHINFO_FILENAME),
                'avatar_extension' => $avatar->getClientOriginalExtension(),
                'avatar_path' => $filePath
            ];

            auth()->user()->update($update_array);

            // Resize User Profile Image
            $profile_image = \Image::make($avatar);

            \Storage::disk('local')->put($filePath.$avatar->getClientOriginalName(), file_get_contents($avatar));

            foreach (config('image.thumbnails.user_profile_image') as $image) {
                $profile_image->resize($image['width'], $image['height'])->save( storage_path('app/' .$filePath.pathinfo($avatar->getClientOriginalName(), PATHINFO_FILENAME).$image['width'].'x'.$image['height'].'.'.$avatar->getClientOriginalExtension() ) );
                \Storage::put($filePath.pathinfo($avatar->getClientOriginalName(), PATHINFO_FILENAME).$image['width'].'x'.$image['height'].'.'.$avatar->getClientOriginalExtension() , file_get_contents( storage_path('app/' .$filePath.pathinfo($avatar->getClientOriginalName(), PATHINFO_FILENAME).$image['width'].'x'.$image['height'].'.'.$avatar->getClientOriginalExtension() ) ) );
                \Storage::setVisibility($filePath.pathinfo($avatar->getClientOriginalName(), PATHINFO_FILENAME).$image['width'].'x'.$image['height'].'.'.$avatar->getClientOriginalExtension(), 'public');
            }

            \Storage::disk('local')->deleteDirectory($filePath);

        }

        if ($request->get('password')) {
            $update_array = array_merge($update_array, ['password' => bcrypt($request->get('password'))]);
        }

        auth()->user()->update($update_array);

        return redirect()->route('backend.profile')->withFlashSuccess(trans("alerts.users.profile_updated"));
    }

    public function unread_messages(EloquentMailRepository $mailRepository) {
        $unread_messages = $mailRepository->getUnReadMessages();
        return response()->json($mailRepository->unReadMessages);
    }

    public function job_applications(Request $request) {
        $jobApplications = \DB::table('job_applications')
                ->join('jobs', 'jobs.id', '=', 'job_applications.job_id')
                ->join('users', 'job_applications.user_id', '=', 'users.id')
                ->where('jobs.company_id', auth()->user()->companyId)
            ->where(function($query) {
                             $query->whereNull('job_applications.accepted_at')
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

        if ($jobApplications) {
            foreach ($jobApplications as $key => $jobApplication) {
                $jobApplications[$key]->{'image'} = User::find($jobApplication->user_id)->getPictureAttribute(25, 25);
                $jobApplications[$key]->{'was_created'} = Carbon::parse($jobApplication->created_at)->diffForHumans();
            }
        }

        return response()->json($jobApplications);
    }

    public function task_assigned(Request $request) {

        $tasks_assigned = \DB::table('staff_task')->
            join('task_project', function ($join) {
                $join->on('task_project.id', '!=','staff_task.task_id')
                    ->whereNull('task_project.read_at');
            })
            ->join('projects', 'projects.id', '=', 'task_project.project_id')
            ->join('users', 'projects.created_by', '=', 'users.id')
            ->where('staff_task.user_id', auth()->user()->id)
            ->select([
                \DB::raw('task_project.title AS task_title'),
                \DB::raw('projects.title AS project_title'),
                \DB::raw('task_project.id AS new_task_id'),
                'staff_task.task_id',
                'staff_task.created_at',
                'users.name',
                \DB::raw('users.id AS user_id'),
            ])
            ->get();

        if ($tasks_assigned) {
            foreach ($tasks_assigned as $key => $task) {
                $tasks_assigned[$key]->{'image'} = User::find($task->user_id)->getPictureAttribute(25, 25);
                $tasks_assigned[$key]->{'was_created'} = Carbon::parse($task->created_at)->diffForHumans();
            }
        }

        return response()->json($tasks_assigned);


    }

    /*     * ********************************************************************************************************** */

    public function employersearch(Request $request) {
        if (access()->hasRole('Employer')) {
            $query = $request->input('emp_search_key');
            if (!empty($query)):

                $jobsResult = $this->searchJobRepo->getJobsPaginated($request, $query, config('jobs.default_per_page'));

                $paginator = $jobsResult['paginator'];
                $jobtitle = $jobsResult['jobtitle'];


                $candidateResult = $this->searchJobSeekerRepo->getJobsSeekersPaginated($request, $query, config('jobs.default_per_page'));

                $paginator1 = $candidateResult['paginator'];
                $candidate_info = $candidateResult['candidate_info'];

                $staffinfo = DB::table('users')->where('name', 'LIKE', '%' . $query . '%')->paginate(10)
                        ->where('employer_id', auth()->user()->employer_id);



                $company_id = auth()->user()->company_id;
                $job_cat_info = DB::table('job_categories')
                                ->join('category_preferences_jobs', 'category_preferences_jobs.job_category_id', '=', 'job_categories.id')
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
                    'jobtitle' => $jobtitle,
                    'staffinfo' => $staffinfo,
                    'job_cat_info' => $job_cat_info,
                    'paginator' => $paginator,
                    'candidate_info' => $candidate_info,
                    'paginator1' => $paginator1,
                ];
                $request->flash();
                return view('backend.emp_search_results', $search_results);


            else:
                return back();
            endif;
        }
    }

    /*     * ********************************************************************************************************* */

    public function showstaffmembers(Request $request, $id) {
        if (access()->hasRole('Employer')) {
            $staff_in_detail = User::find($id);
            $view = [
                'staff_in_detail' => $staff_in_detail
            ];
            return view('frontend.user.profile.employer_staff_show', $view);
        }
    }

    /*     * ********************************************************************************************************* */
}
