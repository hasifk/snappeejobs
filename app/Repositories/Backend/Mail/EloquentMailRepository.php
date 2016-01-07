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
    private $threadParticipants;

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

    public function findOrThrowException($id) {

        $this->thread = Thread::find($id);

        if ( is_null($this->thread) ) {
            throw new GeneralException('That thread does not exist.');
        }

        $threadParticipants = \DB::table('thread_participants')
            ->where('thread_id', $this->thread->id)
            ->select(['user_id', 'sender_id'])
            ->get();

        $threadParticipantsExceptUser = [];

        foreach ($threadParticipants as $threadParticipant) {
            $threadParticipantsExceptUser[] = $threadParticipant->user_id;
            $threadParticipantsExceptUser[] = $threadParticipant->sender_id;
        }

        $threadParticipantsExceptUser = array_diff($threadParticipantsExceptUser, [ auth()->user()->id ]);

        $threadParticipantsExceptUser = array_values($threadParticipantsExceptUser);

        $this->threadParticipants = $threadParticipantsExceptUser;
    }

    public function sendPrivateMessage(Request $request){

        $thread_exists = false;

        if ( $this->shouldCreateNewThread($request->get('to'), auth()->user()->id) ) {
            $thread = $this->thread = $this->createThread($request->all());
        } else {
            $thread = $this->thread;
            $thread_exists = true;
            $this->updateThread($request->all());
        }

        $this->createMessage($request->all());

        if (! $thread_exists) {
            $this->connectThreadUsers($thread, $request->all());
        }

        return;

    }

    public function sendReply(Request $request, $thread_id){

        $this->findOrThrowException($thread_id);

        $this->updateThread($request->all());

        $this->createMessage($request->all());

        $this->connectThreadUsers($this->thread, ['to' => $this->threadParticipants[0]]);
    }

    public function inbox($per_page, $status = 1, $order_by = 'threads.updated_at', $sort = 'desc'){
        $inbox = \DB::table('thread_participants')
            ->join('threads','thread_participants.thread_id','=','threads.id')
            ->join('users','thread_participants.sender_id','=','users.id')
            ->whereNull('thread_participants.deleted_at')
            ->where('thread_participants.user_id',auth()->user()->id)
            ->orderBy('thread_participants.updated_at')
            ->select([
                'users.name',
                'threads.subject',
                'threads.last_message',
                'threads.message_count',
                'threads.created_at',
                'threads.updated_at',
                'thread_participants.thread_id',
                'thread_participants.read_at',
            ])
            ->orderBy($order_by, $sort)->paginate($per_page);

        return $inbox;
    }

    public function sent($per_page, $status = 1, $order_by = 'threads.updated_at', $sort = 'desc'){
        $inbox = \DB::table('thread_participants')
            ->join('threads','thread_participants.thread_id','=','threads.id')
            ->join('users','thread_participants.user_id','=','users.id')
            ->whereNull('thread_participants.deleted_at')
            ->where('thread_participants.sender_id',auth()->user()->id)
            ->orderBy('thread_participants.updated_at')
            ->select([
                'users.name',
                'threads.id',
                'threads.subject',
                'threads.last_message',
                'threads.message_count',
                'threads.created_at',
                'threads.updated_at',
                'thread_participants.thread_id',
                'thread_participants.read_at',
            ])
            ->orderBy($order_by, $sort)->paginate($per_page);

        return $inbox;
    }

    public function getThread($id){

        \DB::table('thread_participants')
            ->where('thread_id', $id)
            ->where('user_id', auth()->user()->id)
            ->update(['read_at' => Carbon::now() ]);

        return Thread::findOrFail($id);
    }

    public function deleteThread($id){
        $this->findOrThrowException($id);

        \DB::table('thread_participants')
            ->where('thread_id', $this->thread->id)
            ->where('user_id', $this->user->user()->id)
            ->update([
                'deleted_at'    => Carbon::now()
            ]);

        return;
    }

    public function createThread($data){

        $thread = Thread::create([
            'subject'               => $data['subject'],
            'last_message'          => $data['message'],
            'message_count'         => 1
        ]);

        return $thread;

    }

    public function updateThread($data){
        $this->thread->last_message = $data['message'];
        $this->thread->message_count = $this->thread->message_count + 1;
        $this->thread->save();
    }

    public function shouldCreateNewThread($receiver_id, $sender_id){

        $dbObject = \DB::table('thread_participants')
            ->where('user_id', $receiver_id)
            ->where('sender_id', $sender_id);

        $count = $dbObject->count();

        if ( ! $count ) {
            return true;
        }
        dd($dbObject->value('thread_id'));
        $this->thread = Thread::find($dbObject->value('thread_id'));

        return false;

    }
    
    public function createMessage($data){

        \DB::table('messages')->insert([
            'thread_id'     => $this->thread->id,
            'sender_id'     => $this->user->user()->id,
            'content'       => $data['message'],
            'created_at'    => Carbon::now(),
            'updated_at'    => Carbon::now(),
        ]);
    }

    public function connectThreadUsers(Thread $thread, $data){

        $count = \DB::table('thread_participants')
            ->where('thread_id', $thread->id)
            ->where('user_id', $data['to'])
            ->where('sender_id', $this->user->user()->id)
            ->count();

        if ( $count ) {
            return;
        }

        \DB::table('thread_participants')->insert([
            'thread_id'     => $thread->id,
            'user_id'       => $data['to'],
            'sender_id'     => $this->user->user()->id,
            'created_at'    => Carbon::now(),
            'updated_at'    => Carbon::now(),
        ]);
    }

}