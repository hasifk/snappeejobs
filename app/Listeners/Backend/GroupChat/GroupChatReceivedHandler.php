<?php

namespace App\Listeners\Backend\GroupChat;

use App\Events\Backend\GroupChat\GroupChatReceived;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class GroupChatReceivedHandler
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
     * @param  GroupChatReceived  $event
     * @return void
     */
    public function handle(GroupChatReceived $event)
    {
        //
    }
}
