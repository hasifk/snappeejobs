<?php

namespace App\Events\Backend\GroupChat;

use App\Events\Event;
use App\Models\Access\User\User;
use App\Models\GroupMessage\GroupMessage;
use Carbon\Carbon;
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

        $group_contacts = \DB::table('staff_employer')
            ->join('users', 'staff_employer.user_id', '=', 'users.id')
            ->where('users.employer_id', auth()->user()->employer_id)
            ->where('staff_employer.user_id', '<>', auth()->user()->id)
            ->select(['users.name'])
            ->get();

        $group_contacts_names = [];
        $group_contacts_replace_names = [];
        foreach ($group_contacts as $key => $group_contact) {
            $group_contacts_names[] = '/@'.$group_contact->name.'/';
            $group_contacts_replace_names[] = '<b>'. '@'.$group_contact->name .'</b>';
        }

        $this->eventDetails = new \stdClass();

        $this->eventDetails->{'message'} = preg_replace($group_contacts_names, $group_contacts_replace_names, $groupMessage->message);
        $this->eventDetails->{'sender_picture'} = User::find($groupMessage->sender_id)->picture;
        $this->eventDetails->{'sent_at'} = Carbon::parse($groupMessage->created_at)->diffForHumans();
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
