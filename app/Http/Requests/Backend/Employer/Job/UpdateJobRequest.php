<?php

namespace App\Http\Requests\Backend\Employer\Job;

use App\Exceptions\Backend\Access\Employer\EmployerNeedsRolesException;
use App\Http\Requests\Request;

class UpdateJobRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return access()->can('employer-jobs-edit');
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
            'title'                 => 'required',
            'level'                 => 'required|in:internship,entry,mid,senior',
            'job_category'          => 'required|array',
            'description'           => 'required',
            'country_id'            => 'required',
            'state_id'              => 'required',
        ];
    }

    private function throwException(){
        $exception = new EmployerNeedsRolesException();
        $exception->setValidationErrors('You are not authorized to do that');

        throw $exception;
    }

}
