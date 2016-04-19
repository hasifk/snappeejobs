<?php

namespace App\Events\Backend\Tasks;

use App\Events\Event;
use App\Models\Access\User\User;
use App\Models\Job\Job;
use App\Models\Newsfeed\Newsfeed;
use App\Models\Task\Task;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class TaskUpdated extends Event implements ShouldBroadcast
{
    use SerializesModels;
    /**
     * @var Job
     */
    public $task;
    /**
     * @var
     */
    public $user;

    public $eventDetails;

    /**
     * Create a new event instance.
     * @param Newsfeed $newsfeed
     * @param $adminuser
     */
    public function __construct( Task $task, User $user)
    {
        $this->task= $task;
        $this->user = $user;

        $this->eventDetails = new \stdClass();

        $this->eventDetails->{'notification_type'} = 'task_updated';
        $this->eventDetails->{'notification_type_text'} = 'Task Updated';
        $this->eventDetails->{'task_title'} = $task->title;
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
            $broadCastOn[] = 'employer_task.'.$staff;
        }

        return $broadCastOn;
    }

    public function broadcastAs(){
        return 'task_notifications';
    }
}
