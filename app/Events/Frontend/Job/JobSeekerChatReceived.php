<?php

namespace App\Events\Frontend\Job;

use App\Events\Event;
use App\Models\Access\User\User;
use App\Models\Job\JobApplication\JobApplication;
use App\Models\Mail\Thread;
use Carbon\Carbon;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class JobSeekerChatReceived extends Event implements ShouldBroadcast, SelfHandling
{
    use SerializesModels;


    private $thread;
    private $job_applicaton;
    public $message_details;

    public function __construct($thread_id)
    {
        $this->thread = Thread::find($thread_id);
        $this->job_applicaton = JobApplication::find($this->thread->application_id);

        $latest_message = \DB::table('messages')
            ->where('thread_id', $this->thread->id)
            ->where('sender_id', $this->thread->employer_id)
            ->orderBy('created_at', 'desc')
            ->skip(0)
            ->take(1)
            ->value('content');

        $this->message_details = new \stdClass();

        $this->message_details->{'last_message'} = str_limit($latest_message, 35);
        $this->message_details->{'image'} = User::find($this->thread->employer_id)->getPictureAttribute(25, 25);
        $this->message_details->{'thread_id'} = $thread_id;
        $this->message_details->{'was_created'} = Carbon::parse($this->thread->updated_at)->diffForHumans();
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return ['user.'.$this->job_applicaton->user_id];
    }

    public function broadcastAs(){
        return 'employerchat-received';
    }
}
