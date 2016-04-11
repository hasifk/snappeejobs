<?php

namespace App\Events\Backend\Project;

use App\Events\Event;
use App\Models\Access\User\User;
use App\Models\Job\Job;
use App\Models\Project\Project;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class ProjectCreated extends Event implements ShouldBroadcast
{
    use SerializesModels;
    /**
     * @var Job
     */
    public $project;
    /**
     * @var
     */
    public $user;

    public $eventDetails;

    /**
     * Create a new event instance.
     *
     * @param Job $job
     * @param $user
     */
    public function __construct(Project $project, User $user)
    {
        $this->project = $project;
        $this->user = $user;

        $this->eventDetails = new \stdClass();

        $this->eventDetails->{'notification_type'} = 'project_created';
        $this->eventDetails->{'notification_type_text'} = 'Project Created';
        $this->eventDetails->{'project_title'} = $project->title;
        $this->eventDetails->{'created_by'} = $user->name;
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
            $broadCastOn[] = 'employer.'.$staff;
        }

        return $broadCastOn;
    }

    public function broadcastAs(){
        return 'project_notifications';
    }
}
