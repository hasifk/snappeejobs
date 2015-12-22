<?php

namespace App\Events\Backend\Account;

use App\Events\Event;
use App\Models\Access\User\User;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class UserCreated extends Event
{
    use SerializesModels;
    /**
     * @var User
     */
    public $createdUser;
    /**
     * @var User
     */
    public $newUser;

    /**
     * Create a new event instance.
     *
     * @param User $newUser
     * @param User $createdUser
     */
    public function __construct(User $newUser, User $createdUser)
    {
        $this->createdUser = $createdUser;
        $this->newUser = $newUser;
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
