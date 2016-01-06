<?php

namespace App\Http\Controllers\Backend\Employer\Mail;

use App\Repositories\Backend\Mail\EloquentMailRepository;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class MailController extends Controller
{
    /**
     * @var EloquentMailRepository
     */
    public $mail;

    /**
     * MailController constructor.
     * @param EloquentMailRepository $mail
     */
    public function __construct(EloquentMailRepository $mail)
    {

        $this->mail = $mail;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('backend.employer.mail.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Requests\Backend\Employer\Mail\EmployerComposeMailViewRequest $request)
    {
        $to_users = $this->mail->getEmployers();

        $view = [
            'to_users' => $to_users
        ];
        return view('backend.employer.mail.create', $view);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function send(Requests\Backend\Employer\Mail\EmployerMailSendNewMessage $request)
    {
        $this->mail->sendPrivateMessage($request);

        return redirect()
            ->route('admin.employer.mail.inbox')
            ->withFlashSuccess('Successfully sent the message');
    }

    public function inbox(Requests\Backend\Employer\Mail\EmployerMailInboxView $request){

        $view = [
            'inbox' => $this->mail->inbox(config('access.users.default_per_page'))
        ];

        return view('backend.employer.mail.inbox', $view);
    }

    public function sent(Requests\Backend\Employer\Mail\EmployerMailInboxView $request){

        $view = [
            'sent' => $this->mail->sent(config('access.users.default_per_page'))
        ];

        return view('backend.employer.mail.sent', $view);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Requests\Backend\Employer\Mail\EmployerMailInboxSingleView $request, $thread_id)
    {
        $view = [
            'thread' => $this->mail->getThread($thread_id)
        ];

        return view('backend.employer.mail.show', $view);
    }

    public function reply(Requests\Backend\Employer\Mail\EmployerMailReplyRequest $request, $thread_id){
        $this->mail->sendReply($request, $thread_id);

        return redirect()
            ->route('admin.employer.mail.sent')
            ->withFlashSuccess('Successfully sent the reply');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
