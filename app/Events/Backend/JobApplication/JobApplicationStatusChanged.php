<?php

namespace App\Events\Backend\JobApplication;

use App\Events\Event;
use App\Models\Job\JobApplication\JobApplication;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class JobApplicationStatusChanged extends Event
{
    use SerializesModels;
    /**
     * @var JobApplication
     */
    public $jobApplication;
    /**
     * @var
     */
    public $job_application_status_company_id;

    /**
     * Create a new event instance.
     *
     * @param JobApplication $jobApplication
     * @param $job_application_status_company_id
     */
    public function __construct(JobApplication $jobApplication, $job_application_status_company_id)
    {

        $this->jobApplication = $jobApplication;
        $this->job_application_status_company_id = $job_application_status_company_id;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [];
    }
}
