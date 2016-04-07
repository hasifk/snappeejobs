<?php

namespace App\Events\Backend\NewsFeed;

use App\Events\Event;
use App\Models\Job\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class NewsFeedCreated extends Event implements ShouldBroadcast
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
     *

     */
    public function __construct($newsfeed, $adminuser)
    {
        $this->newsfeed= $newsfeed;
        $this->adminuser = $adminuser;

        $this->eventDetails = new \stdClass();

        $this->eventDetails->{'notification_type'} = 'news_feed_created';
        $this->eventDetails->{'notification_type_text'} = 'news_feed_created';
        $this->eventDetails->{'newsfeed'} = $newsfeed->newsfeed;
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
