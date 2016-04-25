<?php

namespace App\Listeners\Backend\JobApplication;

use Activity;
use App\Events\Backend\JobApplication\JobApplicationStatusChanged;
use App\Repositories\Backend\Logs\LogsActivitysRepository;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class JobApplicationStatusChangedHandler
{
    /**
     * @var LogsActivitysRepository
     */
    private $userLogs;

    /**
     * Create the event listener.
     *
     * @param LogsActivitysRepository $userLogs
     */
    public function __construct(LogsActivitysRepository $userLogs)
    {
        //
        $this->userLogs = $userLogs;
    }

    /**
     * Handle the event.
     *
     * @param  JobApplicationStatusChanged  $event
     * @return void
     */
    public function handle(JobApplicationStatusChanged $event)
    {
        $jobApplication = $event->jobApplication;
        $job_application_status_company_id = $event->job_application_status_company_id;

        $job_application_status = \DB::table('job_application_status_company')
            ->join('job_application_statuses', 'job_application_statuses.id', '=', 'job_application_status_company.job_application_status_id')
            ->where('job_application_status_company.id', $job_application_status_company_id)
            ->value('job_application_statuses.status');


        switch($job_application_status) {

            case 'applied':
                $this->AppliedStatus();
                break;

            case 'feedback':
                $this->FeedbackStatus();
                break;

            case 'interviewing':
                $this->InterviewingStatus();
                break;

            case 'disqualified':
                $this->DisqualifiedStatus();
                break;

            case 'hired':
                $this->HiredStatus();
                break;


        }
    }

    private function AppliedStatus(){
        $array['type'] = 'Job Application';
        $array['heading'] = 'Status Changed to Applied';
        $array['event'] = 'job application status change to applied';
        $name = $this->userLogs->getActivityDescriptionForEvent($array);
        Activity::log($name);
        \Log::info('job application status changed to applied');
    }

    private function FeedbackStatus(){
        $array['type'] = 'Job Application';
        $array['heading'] = 'Status Changed to feedback';
        $array['event'] = 'job application status change to feedback';
        $name = $this->userLogs->getActivityDescriptionForEvent($array);
        Activity::log($name);
        \Log::info('job application status changed to feedback');
    }

    private function InterviewingStatus(){
        $array['type'] = 'Job Application';
        $array['heading'] = 'Status Changed to interviewed';
        $array['event'] = 'job application status change to interviewed';
        $name = $this->userLogs->getActivityDescriptionForEvent($array);
        Activity::log($name);
        \Log::info('job application status changed to interviewing');
    }

    private function DisqualifiedStatus(){
        $array['type'] = 'Job Application';
        $array['heading'] = 'Status Changed to disqualified';
        $array['event'] = 'job application status change to disqualified';
        $name = $this->userLogs->getActivityDescriptionForEvent($array);
        Activity::log($name);
        \Log::info('job application status changed to disqualified');
    }

    private function HiredStatus(){
        $array['type'] = 'Job Application';
        $array['heading'] = 'Status Changed to hired';
        $array['event'] = 'job application status change to hired';
        $name = $this->userLogs->getActivityDescriptionForEvent($array);
        Activity::log($name);
        \Log::info('job application status changed to hired');
    }

}
