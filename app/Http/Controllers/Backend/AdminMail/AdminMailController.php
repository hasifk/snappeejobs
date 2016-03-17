<?php

namespace App\Http\Controllers\Backend\AdminMail;

use App\Http\Requests\Backend\Admin\Mail\AdminMailSendMessageRequest;
use App\Models\Company\Company;
use App\Models\Mail\Thread;
use App\Repositories\Backend\Admin\Mail\EloquentAdminMailRepository;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class AdminMailController extends Controller
{

    /**
     * @var EloquentAdminMailRepository
     */
    private $mailRepository;

    public function __construct(EloquentAdminMailRepository $mailRepository)
    {

        $this->mailRepository = $mailRepository;
    }

    public function create()
    {

        $companies = Company::select(['id', 'title'])->get();
        $to_users = [];

        if ( old('company') ) {
            $employer_id = \DB::table('companies')->where('id', old('company'))->value('employer_id');
            $to_users = \DB::table('users')->where('employer_id', $employer_id)->select(['id', 'name'])->get();
        }

        $view = [
            'companies' => $companies,
            'to_users'  => $to_users
        ];

        return view('backend.admin.mail.create', $view);
    }

    public function getCompanyUsers(Request $request, $company_id){
        $employer_id = \DB::table('companies')->where('id', $company_id)->value('employer_id');

        $users = \DB::table('users')->where('employer_id', $employer_id)->select(['id', 'name'])->get();

        return response()->json($users);
    }

    public function sendMessage(AdminMailSendMessageRequest $request){

        $this->mailRepository->sendPrivateMessage($request);

        return redirect()
            ->route('admin.mail.index')
            ->withFlashSuccess('Successfully sent the message');

    }

    public function index(){

        $view = [
            'inbox' => $this->mailRepository->inbox(10)
        ];

        return view('backend.admin.mail.index', $view);
    }

    public function sent(){

        $view = [
            'sent' => $this->mailRepository->sent(10)
        ];

        return view('backend.admin.mail.sent', $view);
    }

    public function show(Request $request, $thread_id){

        $view = [
            'thread' => $this->mailRepository->getThread($thread_id)
        ];

        return view('backend.admin.mail.show', $view);
    }

    public function reply(Request $request, $thread_id){
        $this->mailRepository->sendReply($request, $thread_id);

        Thread::find($thread_id);

        return redirect()
            ->route('admin.mail.view', $thread_id)
            ->withFlashSuccess('Successfully sent the reply');
    }


    public function destroy(Request $request, $id)
    {

        $this->mailRepository->deleteThread($id);

        return redirect()
            ->route('admin.mail.index')
            ->withFlashSuccess('Successfully deleted the thread');
    }

}
