<?php namespace App\Listeners\Frontend\Job;

use App\Events\Frontend\Job\JobSeekerChatReceived;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

/**
 * Class UserLoggedInHandler
 * @package App\Listeners\Frontend\Auth
 */
class JobSeekerChatReceivedHandler implements ShouldQueue {

    use InteractsWithQueue;


    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param JobApplied $event
     */
    public function handle(JobSeekerChatReceived $event)
    {
//		\Log::info("User applied for job" . $event);
    }
}
