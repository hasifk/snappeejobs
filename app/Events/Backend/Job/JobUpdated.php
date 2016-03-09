<?php

namespace App\Events\Backend\Job;

use App\Events\Event;
use App\Models\Job\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class JobUpdated extends Event
{
    use SerializesModels;

    /**
     * @var Job
     */
    public $job;
    /**
     * @var
     */
    public $user;

    public $eventDetails;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Job $job, $user)
    {
        $this->job = $job;
        $this->user = $user;

        $this->eventDetails = new \stdClass();

        $this->eventDetails->{'notification_type'} = 'job_updated';
        $this->eventDetails->{'job_title'} = $job->title;
        $this->eventDetails->{'created_by'} = $user->name;
        $this->eventDetails->{'created_by_image'} = $user->picture;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        $staffs = \DB::table('staff_employer')->where('employer_id', $this->user->employer_id)->lists('user_id');

        $broadCastOn = [];

        foreach ($staffs as $staff) {
            $broadCastOn[] = 'employer_staff.'.$staff;
        }

        return $broadCastOn;
    }

    public function broadcastAs(){
        return 'employer_notifications';
    }
}
