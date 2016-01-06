<?php

namespace App\Http\Requests\Backend\Employer\Job;

use App\Exceptions\Backend\Access\Employer\EmployerNeedsRolesException;
use App\Http\Requests\Request;

class CreateJobPageViewRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return access()->can('employer-jobs-add');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        return [
            //
        ];
    }

    private function throwException(){
        $exception = new EmployerNeedsRolesException();
        $exception->setValidationErrors('Please fill in the company details first.');

        throw $exception;
    }
}
