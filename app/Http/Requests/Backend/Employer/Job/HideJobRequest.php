<?php

namespace App\Http\Requests\Backend\Employer\Job;

use App\Exceptions\Backend\Access\Employer\EmployerNeedsRolesException;
use App\Http\Requests\Request;

class HideJobRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return access()->can('employer-jobs-publish');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $companyId = \DB::table('jobs')->where('id', $this->segment(4))->value('company_id');
        if ( auth()->user()->employerCompany->id != $companyId ) {
            $this->throwException();
        }

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
