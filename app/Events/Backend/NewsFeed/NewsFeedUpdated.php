<?php

namespace App\Events\Backend\NewsFeed;

use App\Events\Event;
use App\Models\Access\User\User;
use App\Models\Newsfeed\Newsfeed;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class NewsFeedUpdated extends Event implements ShouldBroadcast
{
    use SerializesModels;
    /**
     * @var Job
     */
    public $newsfeed;
    /**
     * @var
     */
    public $adminuser;

    public $eventDetails;

    /**
     * Create a new event instance.
     * @param Newsfeed $newsfeed
     * @param $adminuser
     */
    public function __construct(Newsfeed $newsfeed, User $adminuser)
    {
        $this->newsfeed= $newsfeed;
        $this->adminuser = $adminuser;

        $this->eventDetails = new \stdClass();

        $this->eventDetails->{'notification_type'} = 'news_feed_updated';
        $this->eventDetails->{'notification_type_text'} = 'News From Admin';
        $this->eventDetails->{'newsfeed'} = $newsfeed->news;
        $this->eventDetails->{'created_by'} = $adminuser->name;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        $staffs = \DB::table('staff_employer')->lists('user_id');

        $broadCastOn = [];

        foreach ($staffs as $staff) {
            $broadCastOn[] = 'employer.'.$staff;
        }

        return $broadCastOn;
    }

    public function broadcastAs(){
        return 'newsfeed_notifications';
    }
}
