<?php

namespace App\Http\Requests\Backend\Employer\Staff;

use App\Exceptions\Backend\Access\Employer\EmployerNeedsRolesException;
use App\Http\Requests\Request;

class EmployerChoosePlanRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return access()->can('employer-settings');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        if ( ! in_array( $this->segment(5), array_keys(config('subscription.employer_plans')) ) ) {
            $this->throwException();
        }

        return [

        ];
    }

    private function throwException()
    {
        $exception = new EmployerNeedsRolesException();
        $exception->setValidationErrors('Please select a valid plan');

        throw $exception;
    }

}
