<?php

namespace App\Http\Requests\Backend\Employer\GroupChat;

use App\Exceptions\Backend\Company\CompanyNeedDataFilledException;
use App\Http\Requests\Request;

class EmployerViewGroupChatPageRequest extends Request
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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        $group_contacts = \DB::table('staff_employer')
            ->join('users', 'staff_employer.user_id', '=', 'users.id')
            ->where('users.employer_id', auth()->user()->employer_id)
            ->where('staff_employer.user_id', '<>', auth()->user()->id)
            ->count();

        if ( ! $group_contacts ) {
            $this->throwException();
        }

        return [
            //
        ];
    }

    private function throwException(){
        $exception = new CompanyNeedDataFilledException();
        $exception->setValidationErrors('There are no employees to chat with.');

        throw $exception;
    }
}
