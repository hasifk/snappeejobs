<?php namespace App\Providers;

use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

/**
 * Class EventServiceProvider
 * @package App\Providers
 */
class EventServiceProvider extends ServiceProvider {

	/**
	 * The event handler mappings for the application.
	 *
	 * @var array
	 */
	protected $listen = [
		/**
		 * Frontend Events
		 */
		'App\Events\Frontend\Auth\UserLoggedIn' => [
			'App\Listeners\Frontend\Auth\UserLoggedInHandler',
		],
		'App\Events\Frontend\Auth\UserLoggedOut' => [
			'App\Listeners\Frontend\Auth\UserLoggedOutHandler',
		],
		'App\Events\Backend\Account\UserCreated' => [
			'App\Listeners\Backend\Account\UserCreatedHandler',
		],
		'App\Events\Backend\Company\CompanyCreated' => [
			'App\Listeners\Backend\Company\CompanyCreatedHandler',
		],
		'App\Events\Backend\Job\JobCreated' => [
			'App\Listeners\Backend\Job\JobCreatedHandler',
		],
		'App\Events\Backend\Job\JobUpdated' => [
			'App\Listeners\Backend\Job\JobUpdatedHandler',
		],
		'App\Events\Backend\Job\JobDeleted' => [
			'App\Listeners\Backend\Job\JobDeletedHandler',
		],
		'App\Events\Frontend\Job\JobApplied' => [
			'App\Listeners\Frontend\Job\JobAppliedHandler',
		],
		'App\Events\Frontend\Job\JobSeekerChatReceived' => [
			'App\Listeners\Frontend\Job\JobSeekerChatReceivedHandler',
		],
		'App\Events\Backend\Mail\EmployerChatReceived' => [
			'App\Listeners\Backend\Mail\EmployerChatReceivedHandler',
		],
		'App\Events\Backend\GroupChat\GroupChatReceived' => [
			'App\Listeners\Backend\GroupChat\GroupChatReceivedHandler'
		]
	];

	/**
	 * Register any other events for your application.
	 *
	 * @param  \Illuminate\Contracts\Events\Dispatcher  $events
	 * @return void
	 */
	public function boot(DispatcherContract $events)
	{
		parent::boot($events);

		//
	}
}
