<?php namespace App\Listeners\Frontend\Job;

use App\Events\Frontend\Job\JobApplied;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

/**
 * Class UserLoggedInHandler
 * @package App\Listeners\Frontend\Auth
 */
class JobAppliedHandler implements ShouldQueue {

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
	public function handle(JobApplied $event)
	{
//		\Log::info("User applied for job" . $event);
	}
}
