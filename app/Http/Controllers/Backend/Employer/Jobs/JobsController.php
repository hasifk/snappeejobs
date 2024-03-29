<?php

namespace App\Http\Controllers\Backend\Employer\Jobs;

use App\Events\Backend\Job\JobDeleted;
use App\Events\Backend\JobApplication\JobApplicationStatusChanged;
use App\Events\Frontend\Job\JobSeekerChatReceived;
use App\Http\Requests\Backend\Employer\Job\EmployerJobApplicationStatusEditRequest;
use App\Http\Requests\Backend\Employer\Job\HideJobRequest;
use App\Http\Requests\Backend\Employer\Job\JobApplicationChangeStatus;
use App\Http\Requests\Backend\Employer\Job\MarkJobRequest;
use App\Http\Requests\Backend\Employer\Job\PublishJobRequest;
use App\Models\Job\Job;
use App\Models\Job\JobApplication\JobApplication;
use App\Models\JobSeeker\JobSeeker;
use App\Repositories\Backend\Job\EloquentJobRepository;
use App\Repositories\Backend\Logs\LogsActivitysRepository;
use App\Repositories\Backend\Mail\EloquentMailRepository;
use App\Repositories\Backend\Permission\PermissionRepositoryContract;
use App\Repositories\Backend\Role\RoleRepositoryContract;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Activity;
class JobsController extends Controller
{
    /**
     * @var EloquentJobRepository
     */
    private $jobs;
    /**
     * @var RoleRepositoryContract
     */
    private $roles;
    /**
     * @var PermissionRepositoryContract
     */
    private $permissions;
    private $userLogs;
    private $mail;
    /**
     * JobsController constructor.
     * @param EloquentJobRepository $jobs
     * @param RoleRepositoryContract $roles
     * @param PermissionRepositoryContract $permissions
     */
    public function __construct(EloquentJobRepository $jobs, RoleRepositoryContract $roles, PermissionRepositoryContract $permissions,
LogsActivitysRepository $userLogs,EloquentMailRepository $mail)
    {
        $this->jobs = $jobs;
        $this->roles = $roles;
        $this->permissions = $permissions;
        $this->userLogs = $userLogs;
        $this->mail = $mail;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('backend.employer.jobs.index')
            ->withJobs($this->jobs->getJobsPaginated(config('jobs.default_per_page'), 1));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Requests\Backend\Employer\Job\CreateJobPageViewRequest $request)
    {
        $job_categories = \DB::table('job_categories')->select(['id', 'name'])->get();
        $countries = \DB::table('countries')->select(['id', 'name'])->get();
        $skills = \DB::table('skills')->select(['id', 'name'])->get();

        if ( $request->old('country_id') ) {

            $states = \DB::table('states')
                ->where('country_id', $request->old('country_id'))
                ->select(['id', 'name'])
                ->get();

        } else {

            $states = \DB::table('states')
                ->where('country_id', 222)
                ->select(['id', 'name'])
                ->get();

        }

        $view = [
            'countries'         => $countries,
            'states'            => $states,
            'job_categories'    => $job_categories,
            'skills'            => $skills
        ];

        return view('backend.employer.jobs.create', $view);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Requests\Backend\Employer\Job\CreateJobRequest $request)
    {
        $array['type'] = 'Job';
        $array['heading']='Name:'.$request->title;
        if($this->jobs->create($request))
        {
            $array['event'] = 'created';

            $name = $this->userLogs->getActivityDescriptionForEvent($array);
            Activity::log($name);
        }

        return redirect()
            ->route('admin.employer.jobs.index')
            ->withFlashSuccess('Successfully created the job');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Requests\Backend\Employer\Job\EditJobViewRequest $request, $id)
    {

        $job = $this->jobs->findOrThrowException($id);

        $job_categories = \DB::table('job_categories')->select(['id', 'name'])->get();
        $skills = \DB::table('skills')->select(['id', 'name'])->get();
        $countries = \DB::table('countries')->select(['id', 'name'])->get();

        if ( $request->old('country_id') || ( $job && $job->country_id ) ) {
            $country_id = $request->old('country_id') ? $request->old('country_id') : $job->country_id;
            $states = \DB::table('states')->where('country_id', $country_id)->select(['id', 'name'])->get();
        } else {
            $states = \DB::table('states')->where('country_id', 222)->select(['id', 'name'])->get();
        }

        $view = [
            'job'                   => $job,
            'countries'             => $countries,
            'states'                => $states,
            'job_categories'        => $job_categories,
            'skills'                => $skills
        ];

        return view('backend.employer.jobs.edit', $view);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Requests\Backend\Employer\Job\UpdateJobRequest $request, $id)
    {
        $job =Job::find($id);
        $array['type'] = 'Job';
        $array['heading']='Name:'.$job->title;
       if($this->jobs->update($id,$request->all()))
       {
           $array['event'] = 'updated';

           $name = $this->userLogs->getActivityDescriptionForEvent($array);
           Activity::log($name);
       }

        return redirect()->route('admin.employer.jobs.index')->withFlashSuccess("The job was successfully updated.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Requests\Backend\Employer\Job\DeleteJobRequest $request, $id)
    {
        $job =Job::find($id);
        $array['type'] = 'Job';
        $array['heading']='Name:'.$job->title;

        if($this->jobs->destroy($id))
        {
            $array['event'] = 'deleted';

            $name = $this->userLogs->getActivityDescriptionForEvent($array);
            Activity::log($name);
        }
        return redirect()->back()->withFlashSuccess('Job deleted successfully');
    }

    /**
     * @param $id
     * @param $status
     * @param MarkJobRequest $request
     * @return mixed
     */
    public function mark($id, $status, MarkJobRequest $request) {
        $job =Job::find($id);
        $array['type'] = 'Job';
        $array['heading']='Name:'.$job->title;

       if($this->jobs->mark($id, $status))
       {
           $array['event'] = 'updated';

           $name = $this->userLogs->getActivityDescriptionForEvent($array);
           Activity::log($name);
       }

        return redirect(route('admin.employer.jobs.index'))->withFlashSuccess('The job was successfully updated.');
    }

    public function publish($id, PublishJobRequest $request)
    {
        $job =Job::find($id);
        $array['type'] = 'Job';
        $array['heading']='Name:'.$job->title;

        if($this->jobs->publish($id))
        {
            $array['event'] = 'published';

            $name = $this->userLogs->getActivityDescriptionForEvent($array);
            Activity::log($name);
        }

        return redirect(route('admin.employer.jobs.index'))->withFlashSuccess('The job was successfully updated.');
    }

    public function hide($id, HideJobRequest $request)
    {
        $job =Job::find($id);
        $array['type'] = 'Job';
        $array['heading']='Name:'.$job->title;
        if($this->jobs->hide($id))
        {
            $array['event'] = 'hide';

            $name = $this->userLogs->getActivityDescriptionForEvent($array);
            Activity::log($name);
        }

        return redirect(route('admin.employer.jobs.index'))->withFlashSuccess('The job was successfully updated.');
    }

    public function deleted() {
        return view('backend.employer.jobs.deleted')
            ->withJobs($this->jobs->getDeletedJobsPaginated(config('jobs.default_per_page'), 1));
    }

    public function disabled() {
        return view('backend.employer.jobs.disabled')
            ->withJobs($this->jobs->getDisabledJobsPaginated(config('jobs.default_per_page'), 1));
    }

    public function hidden() {
        return view('backend.employer.jobs.hidden')
            ->withJobs($this->jobs->getHiddenJobsPaginated(config('jobs.default_per_page'), 1));
    }

    public function applications(Requests\Backend\Employer\Job\ViewJobApplicationsViewRequest $request){
        return view('backend.employer.jobs.applications')->with(['jobapplications' => $this->jobs->getJobApplications(config('jobs.default_per_page'), 1)]);
    }

    public function application(Requests\Backend\Employer\Job\ViewJobApplicationsViewRequest $request, $id){

        $job_application = $this->jobs->getJobApplication($id);

        $job_seeker = JobSeeker::find(\DB::table('job_seeker_details')->where('user_id', $job_application->jobseeker->id)->value('id'));

        $view = [
            'job_application'   => $job_application,
            'job_seeker'       => $job_seeker
        ];

        return view('backend.employer.jobs.application', $view);
    }
/************************************************************************************************************************/
    public function applicationinbox(){

        $view = [
            'inbox' => $this->mail->applicationinbox(config('access.users.default_per_page'))
        ];

        return view('backend.employer.jobs.applicationinbox', $view);
    }
 /******************************************************************************************************************************/
    public function applicationChangeStatus(JobApplicationChangeStatus $request, $id){

        $job_application_id = \DB::table('job_applications')
            ->where('job_id', $id)
            ->where('user_id', $request->get('user_id'))
            ->where('job_application_status_company_id', $request->get('from_status'))
            ->value('id');

        \DB::table('job_applications')
            ->where('job_id', $id)
            ->where('user_id', $request->get('user_id'))
            ->where('job_application_status_company_id', $request->get('from_status'))
            ->update([
                'job_application_status_company_id' => $request->get('to_status')
            ]);

        \DB::table('job_application_status_history')->insert([
            'job_application_id' => $job_application_id,
            'job_application_status_company_id' => $request->get('to_status'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        $jobApplication = JobApplication::find($job_application_id);

        event(new JobApplicationStatusChanged($jobApplication, $request->get('to_status')));

        return response()->json(['status' => 1]);

    }

    public function acceptJobApplication(Requests\Backend\Employer\Job\AcceptJobApplicationRequest $request, EloquentMailRepository $mailRepository, $id){

        $jobApplication = JobApplication::find($id);

        $jobApplication->accepted_by = auth()->user()->id;
        $jobApplication->accepted_at = Carbon::now();

        $jobApplication->save();
        $subject='Job Application - ' .
            $jobApplication->job->title . ' - ' .
            $jobApplication->job->company->title;

        $request->merge([
            'to'            => $jobApplication->user_id,
            'subject'       => $subject,
            'message'       => 'The recruiter of the ' . $jobApplication->job->company->title .
                                ' wants to chat with you regarding the opening for the post of ' .
                                $jobApplication->job->title
        ]);

        $thread = $mailRepository->sendPrivateMessage($request);
        $thread->subject = $subject;
        $thread->application_id = $jobApplication->id;
        $thread->employer_id = auth()->user()->id;

        $thread->save();

        event(new JobSeekerChatReceived($thread->id));

        return redirect(route('admin.employer.mail.view', $thread->id))
            ->withFlashSuccess('The jobseeker was notified about the job acceptance');

    }

    public function declineJobApplication(Requests\Backend\Employer\Job\DeclineJobApplicationRequest $request, $id){

        $jobApplication = JobApplication::find($id);

        $jobApplication->declined_by = auth()->user()->id;
        $jobApplication->declined_at = Carbon::now();

        $jobApplication->save();

        return redirect(route('admin.employer.jobs.applications'))
            ->withFlashSuccess('The jobseeker was notified about the job refusal');

    }

    public function manage(Requests\Backend\Employer\Job\ViewJobApplicationsViewRequest $request, $id){

        $job_applications = JobApplication::where('job_id', $id)->get();

        $job_application_statuses_company = \DB::table('job_application_status_company')
            ->where('employer_id', auth()->user()->employer_id)
            ->get();

        $view = [
            'job_id' => $id,
            'job_applications' => $job_applications,
            'job_application_statuses_company' => $job_application_statuses_company
        ];

        return view('backend.employer.jobs.manage', $view);
    }

    public function manageApplicationStatus(){
        $job_application_statuses = \DB::table('job_application_status_company')
            ->where('employer_id', auth()->user()->employer_id)
            ->get();

        $view = [
            'job_application_statuses' => $job_application_statuses
        ];
        return view('backend.employer.jobs.manageapplicationstatus', $view);
    }

    public function editApplicationStatus(EmployerJobApplicationStatusEditRequest $request, $id){

        $job_application_status = \DB::table('job_application_status_company')
            ->where('employer_id', auth()->user()->employer_id)
            ->where('id', $id)
            ->first();

        $job_application_real_name = \DB::table('job_application_statuses')
            ->where('id', $job_application_status->job_application_status_id)
            ->value('name');

        $view = [
            'job_application_status' => $job_application_status,
            'job_application_real_name' => $job_application_real_name
        ];

        return view('backend.employer.jobs.manageapplicationstatusedit', $view);
    }

    public function updateApplicationStatus(Requests\Backend\Employer\Job\EmployerJobApplicationStatusUpdateRequest $request, $id){

        \DB::table('job_application_status_company')
            ->where('employer_id', auth()->user()->employer_id)
            ->where('id', $id)
            ->update([
                'name' => $request->get('name')
            ]);

        return redirect(route('admin.employer.jobs.manage.applicationstatus'))
            ->withFlashSuccess('The status name has been updated');

    }

}
