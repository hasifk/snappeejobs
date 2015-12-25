<?php

namespace App\Http\Requests\Backend\Employer\Staff;

use App\Http\Requests\Request;

class DeleteEmployerRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return access()->can('delete-employer-staff');;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [];

        $this->userId = $this->segment(4);

        $this->employerId = \DB::table('staff_employer')->where('user_id', $this->userId)->value('employer_id');

        if ( $this->employerId ) {
            $this->staffs = \DB::table('staff_employer')->where('employer_id', $this->employerId)->lists('user_id');

            if ( $this->staffs ) {
                if ( ! in_array( auth()->user()->id , $this->staffs) ) {
                    $this->throwException();
                }
            }
        } else {
            $this->throwException();
        }

        return $rules;
    }

    private function throwException()
    {
        $exception = new EmployerNeedsRolesException();
        $exception->setValidationErrors('You are not authorized to do that');

        throw $exception;
    }
}
