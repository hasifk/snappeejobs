<?php

namespace App\Listeners\Backend\Mail;

use App\Events\Backend\Mail\EmployerChatReceived;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class EmployerChatReceivedHandler
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
     * @param  EmployerChatReceived  $event
     * @return void
     */
    public function handle(EmployerChatReceived $event)
    {
        //
    }
}
