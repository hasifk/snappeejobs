<?php

namespace App\Http\Requests\Backend\Employer\Mail;

use App\Exceptions\Backend\Access\Employer\Mail\MessageDoesNotBelongToUser;
use App\Http\Requests\Request;

class EmployerMailReplyRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return access()->can('mail-send-private-message');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $employer_id = auth()->user()->employerId;

        if ( is_null($employer_id) ) {
            $this->throwException();
        }

        $staffs = \DB::table('staff_employer')
            ->join('users', 'staff_employer.user_id', '=', 'users.id')
            ->where('staff_employer.employer_id', $employer_id)
            ->lists('staff_employer.user_id');

        if ( ! in_array(auth()->user()->id, $staffs) ) {
            $this->throwException();
        }

        $thread_participants = \DB::table('thread_participants')
            ->where('thread_id', $this->segment(5))
            ->select(['user_id', 'sender_id'])
            ->get();

        $thread_participant_ids = [];

        foreach ($thread_participants as $thread_participant) {
            $thread_participant_ids[] = $thread_participant->user_id;
            $thread_participant_ids[] = $thread_participant->sender_id;
        }

        $thread_participant_ids = array_unique($thread_participant_ids);

        if ( ! in_array(auth()->user()->id, $thread_participant_ids) ) {
            $this->throwException();
        }

        return [
            //
        ];
    }

    private function throwException(){
        $exception = new MessageDoesNotBelongToUser();
        $exception->setValidationErrors('You are not authorized to do that.');

        throw $exception;
    }

}
