<?php

namespace App\Events\Backend\GroupChat;

use App\Events\Event;
use App\Models\GroupMessage\GroupMessage;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class GroupChatReceived extends Event implements ShouldBroadcast
{
    use SerializesModels;


    /**
     * @var GroupMessage
     */
    private $groupMessage;

    public $eventDetails;

    public function __construct(GroupMessage $groupMessage)
    {
        $this->groupMessage = $groupMessage;
    }


    public function broadcastOn()
    {

        $group_token = \DB::table('users')->where('employer_id', $this->groupMessage->employer_id)->value('group_token');

        return ['group_chat'.$group_token];
    }

    public function broadcastAs(){
        return ['chat_received'];
    }
}
