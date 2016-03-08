<?php

namespace App\Http\Requests\Frontend\User;

use App\Exceptions\Frontend\Profile\ThreadDoesNotExists;
use App\Http\Requests\Request;
use App\Models\Mail\Thread;

class JobSeekerReplyMessage extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    public function rules()
    {

        $thread_id = $this->segment(3);

        $thread = Thread::findOrFail($thread_id);

        $thread_participants = \DB::table('thread_participants')->where('thread_id', $thread->id)->lists('user_id');

        if ( ! in_array(auth()->user()->id, $thread_participants) ) {
            $this->throwException('This message does not exist');
        }

        return [
            //
        ];
    }

    private function throwException($message){
        $exception = new ThreadDoesNotExists();
        $exception->setValidationErrors($message);

        throw $exception;
    }
}
