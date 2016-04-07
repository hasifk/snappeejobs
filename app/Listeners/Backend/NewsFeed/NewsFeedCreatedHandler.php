<?php
namespace App\Listeners\Backend\NewsFeed;


use App\Events\Backend\NewsFeed\NewsFeedCreated;
use Carbon\Carbon;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class NewsFeedCreatedHandler
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  JobCreated  $event
     * @return void
     */
    public function handle(NewsFeedCreated $event)
    {
        // Insert into employer_notifications table for all the employers of this company

        $staffs = \DB::table('staff_employer')->lists('user_id');

        $adminuser = $event->adminuser;
        $newsfeed = $event->newsfeed;

        $details = serialize([
            'adminuser'  => $adminuser,
            'newsfeed'   => $newsfeed
        ]);

        foreach ($staffs as $staff) {
            \DB::table('employer_notifications')->insert([
                'user_id'           => $staff,
                'from_admin'        =>1,
                'notification_type' => 'news_feed_created',
                'details'           => $details,
                'created_at'        => Carbon::now(),
                'updated_at'        => Carbon::now()
            ]);
        }

    }
}
