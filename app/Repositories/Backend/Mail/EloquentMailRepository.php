<?php

namespace App\Repositories\Backend\Mail;


use App\Events\Backend\Company\CompanyCreated;
use App\Exceptions\GeneralException;
use App\Models\Access\User\User;
use App\Models\Company\Company;
use App\Models\Mail\Thread;
use App\Repositories\Backend\Role\RoleRepositoryContract;
use App\Repositories\Frontend\Auth\AuthenticationContract;
use Carbon\Carbon;
use Event;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;

class EloquentMailRepository
{
    /**
     * @var RoleRepositoryContract
     */
    private $role;
    /**
     * @var AuthenticationContract
     */
    private $auth;
    /**
     * @var Guard
     */
    private $user;
    private $employerId;
    private $thread;

    /**
     * EloquentCompanyRepository constructor.
     * @param RoleRepositoryContract $role
     * @param AuthenticationContract $auth
     * @param Guard $user
     */
    public function __construct(RoleRepositoryContract $role, AuthenticationContract $auth, Guard $user)
    {

        $this->role = $role;
        $this->auth = $auth;
        $this->user = $user;
        $this->employerId = $this->user->user() ? $this->getemployerId($this->user->user()) : null;
    }

    public function getemployerId(User $user){
        $employer_id = \DB::table('staff_employer')
            ->where('user_id', $user->id)
            ->where('is_admin', true)
            ->orderBy('created_at')
            ->value('employer_id');
        return $employer_id;
    }

    public function getEmployers(){
        return \DB::table('staff_employer')
            ->join('users', 'staff_employer.user_id', '=', 'users.id')
            ->where('staff_employer.employer_id', $this->employerId)
            ->where('staff_employer.user_id', '<>', $this->user->user()->id)
            ->select(['users.id', 'users.name'])
            ->get();
    }

    public function sendPrivateMessage(Request $request){

        $thread_exists = false;

        if ( $this->shouldCreateNewThread($request->get('to'), auth()->user()->id) ) {
            $thread = $this->thread = $this->createThread($request);
        } else {
            $thread = $this->thread;
            $thread_exists = true;
        }

        $this->createMessage($request);

        if (! $thread_exists) {
            $this->connectThreadUsers($thread, $request);
        }

        return;

    }
    
    public function createThread(Request $request){

        $thread = Thread::create([
            'subject'               => $request->get('subject'),
            'last_message'          => '',
            'message_count'         => 1
        ]);

        return $thread;

    }

    public function shouldCreateNewThread($receiver_id, $sender_id){

        $dbObject = \DB::table('thread_participants')
            ->where('user_id', $receiver_id)
            ->where('sender_id', $sender_id);

        $count = $dbObject->count();

        if ( ! $count ) {
            return true;
        }

        $this->thread = Thread::find($dbObject->value('thread_id'));

        return true;

    }
    
    public function createMessage(Request $request){

        \DB::table('messages')->insert([
            'thread_id'     => $this->thread->id,
            'sender_id'     => $this->user->user()->id,
            'content'       => $request->get('message'),
            'created_at'    => Carbon::now(),
            'updated_at'    => Carbon::now(),
        ]);

    }

    public function connectThreadUsers(Thread $thread, Request $request){
        \DB::table('thread_participants')->insert([
            'thread_id'     => $thread->id,
            'user_id'       => $request->get('to'),
            'sender_id'     => $this->user->user()->id,
            'created_at'    => Carbon::now(),
            'updated_at'    => Carbon::now(),
        ]);
    }

}