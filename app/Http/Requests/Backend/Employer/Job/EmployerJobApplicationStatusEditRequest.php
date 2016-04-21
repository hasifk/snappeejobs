<?php

namespace App\Http\Requests\Backend\Employer\Job;

use App\Exceptions\Backend\Access\Employer\EmployerNeedsRolesException;
use App\Http\Requests\Request;

class EmployerJobApplicationStatusEditRequest extends Request
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

        $id = $this->segment(6);

        $job_application_status = \DB::table('job_application_status_company')
            ->where('employer_id', auth()->user()->employer_id)
            ->where('id', $id)
            ->count();

        if ( ! $job_application_status ) {
             $this->throwException();
        }

        return [];
    }

    private function throwException(){
        $exception = new EmployerNeedsRolesException();
        $exception->setValidationErrors('You are not authorized to do that');

        throw $exception;
    }
}
