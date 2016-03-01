<?php

namespace App\Events\Frontend\Job;

use App\Events\Event;
use App\Models\Job\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Support\Collection;

class JobApplied extends Event implements ShouldBroadcast
{
    use SerializesModels;
    /**
     * @var Collection
     */
    public $employerUsersCollection;
    /**
     * @var Job
     */
    private $job;

    /**
     * JobApplied constructor.
     * @param Collection $employerUsersCollection
     * @param Job $job
     */
    public function __construct(Collection $employerUsersCollection, Job $job)
    {
        $this->employerUsersCollection = $employerUsersCollection;
        $this->job = $job;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        $user_ids = $this->employerUsersCollection->map(function($user, $key) {
            return 'user.' . $user->id;
        });

        return $user_ids->all();
    }

    /**
     * The event name to be broadcasted
     * @return string
     */
    public function broadcastAs(){
        return 'jobapplication-received';
    }
}
