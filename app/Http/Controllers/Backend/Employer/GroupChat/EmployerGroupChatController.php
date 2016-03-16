<?php

namespace App\Http\Controllers\Backend\Employer\GroupChat;

use App\Events\Backend\GroupChat\GroupChatReceived;
use App\Models\Access\User\User;
use App\Models\GroupMessage\GroupMessage;
use App\Models\GroupMessage\GroupMessageMention;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class EmployerGroupChatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function chat(Requests\Backend\Employer\GroupChat\EmployerViewGroupChatPageRequest $request)
    {
        $group_contacts = \DB::table('staff_employer')
        ->join('users', 'staff_employer.user_id', '=', 'users.id')
        ->where('users.employer_id', auth()->user()->employer_id)
        ->select(['users.id', 'users.name', 'users.email'])
        ->get();

        $group_messages = GroupMessage::where('employer_id', auth()->user()->employer_id)
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        $group_contacts_names = [];
        $group_contacts_replace_names = [];
        foreach ($group_contacts as $key => $group_contact) {
            $group_contacts_names[] = '/@'.$group_contact->name.'/';
            $group_contacts_replace_names[] = '<b>'. '@'.$group_contact->name .'</b>';
        }

        $pattern = '/'.implode('|', $group_contacts_names).'/';

        $group_token = \DB::table('users')->where('employer_id', auth()->user()->employer_id)->value('group_token');

        $view = [
            'group_contacts'                    => $group_contacts,
            'group_messages'                    => $group_messages,
            'pattern'                           => $pattern,
            'group_token'                       => $group_token,
            'group_contacts_names'              => $group_contacts_names,
            'group_contacts_replace_names'      => $group_contacts_replace_names
        ];

        return view('backend.employer.groupchat.index', $view);
    }

    public function sendmessage(Request $request){

        if ( ! $request->get('message') ) {
            return;
        }

        $group_contacts = \DB::table('staff_employer')
            ->join('users', 'staff_employer.user_id', '=', 'users.id')
            ->where('users.employer_id', auth()->user()->employer_id)
            ->where('staff_employer.user_id', '<>', auth()->user()->id)
            ->lists('users.name');

        foreach ($group_contacts as $key => $group_contact) {
            $group_contacts[$key] = '@'.$group_contact;
        }

        $pattern = '/'.implode('|', $group_contacts).'/';

        preg_match($pattern, $request->get('message'), $matches);

        $group_message = GroupMessage::create([
            'employer_id'   => auth()->user()->employer_id,
            'sender_id'     => auth()->user()->id,
            'message'       => $request->get('message')
        ]);

        event(new GroupChatReceived($group_message));

        if ( $matches ) {

            $users_to_be_notified = [];
            foreach ($matches as $match) {
                $username = substr($match, 1);
                if ( User::where('name', $username)->count() ) {
                    $users_to_be_notified[] = User::where('name', $username)->first();
                }
            }

            if ( $users_to_be_notified ) {

                foreach ($users_to_be_notified as $item) {
                    GroupMessageMention::create([
                        'group_message_id'  => $group_message->id,
                        'user_id'           => $item->id
                    ]);
                }
            }

            return response()->json(['status' => 1]);
        }

        return response()->json(['status' => 0]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
