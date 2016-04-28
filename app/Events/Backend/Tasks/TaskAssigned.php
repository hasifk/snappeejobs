<?php

namespace App\Events\Backend\Tasks;

use App\Events\Event;
use App\Models\Access\User\User;
use App\Models\Task\Task;
use Carbon\Carbon;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class TaskAssigned extends Event implements ShouldBroadcast
{
    use SerializesModels;

    public $eventDetails;
    /**
     * @var Task
     */
    private $task;
    /**
     * @var User
     */
    private $user;
    /**
     * @var array
     */
    private $previousMembers;
    /**
     * @var array
     */
    private $currentMembers;

    /**
     * Create a new event instance.
     *
     * @param Task $task
     * @param User $user
     * @param $previousMembers
     * @param $currentMembers
     */
    public function __construct(Task $task, User $user, array $previousMembers, array $currentMembers)
    {
        $this->task = $task;
        $this->user = $user;
        $this->previousMembers = $previousMembers;
        $this->currentMembers = $currentMembers;

        $this->eventDetails = new \stdClass();

        $this->eventDetails->{'task_title'} = $task->title;
        $this->eventDetails->{'project_title'} = $task->projectname;
        $this->eventDetails->{'image'} = User::find($task->created_by)->getPictureAttribute(25, 25);
        $this->eventDetails->{'was_created'} = Carbon::parse($task->created_at)->diffForHumans();
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {

        if ( empty($this->previousMembers) ) {
            foreach ($this->currentMembers as $staff) {
                $broadCastOn[] = 'employer_task.'.$staff;
            }
        } else {
            $staffs = array_diff($this->currentMembers, $this->previousMembers);

            foreach ($staffs as $staff) {
                $broadCastOn[] = 'employer_task.'.$staff;
            }
        }

        return $broadCastOn;
    }

    public function broadcastAs(){
        return 'task_notifications';
    }
}
