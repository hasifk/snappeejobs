<?php

namespace App\Http\Requests\Backend\Employer\Job;

use App\Exceptions\Backend\Access\Employer\EmployerNeedsRolesException;
use App\Http\Requests\Request;

class JobApplicationChangeStatus extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return access()->can('employer-jobs-view-jobapplications');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        $companyId = \DB::table('jobs')->where('id', $this->segment(6))->value('company_id');

        if ( auth()->user()->employerCompany->id != $companyId ) {
            $this->throwException();
        }

        return [
            //
        ];
    }

    private function throwException(){
        $exception = new EmployerNeedsRolesException();
        $exception->setValidationErrors('You are not authorized to do that.');

        throw $exception;
    }
}
