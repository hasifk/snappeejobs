<?php

namespace App\Http\Requests\Backend\Employer\Mail;

use App\Exceptions\Backend\Access\Employer\EmployerNeedsRolesException;
use App\Http\Requests\Request;

class EmployerMailSendNewMessage extends Request
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

        return [
            'to'                => 'required',
            'subject'           => 'required',
            'message'           => 'required',
        ];
    }

    private function throwException(){
        $exception = new EmployerNeedsRolesException();
        $exception->setValidationErrors('You are not authorized to do that.');

        throw $exception;
    }
}
