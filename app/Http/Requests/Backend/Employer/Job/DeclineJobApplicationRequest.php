<?php

namespace App\Http\Requests\Backend\Employer\Job;

use App\Exceptions\Backend\Access\Employer\EmployerNeedsRolesException;
use App\Http\Requests\Request;
use App\Models\Job\Job;
use App\Models\Job\JobApplication\JobApplication;

class DeclineJobApplicationRequest extends Request
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

        $jobApplication = JobApplication::findOrFail($this->segment(6));

        if ( $jobApplication->accepted_at ) {
            $this->throwException('This job application has already been accepted.');
        }

        if ( $jobApplication->declined_at ) {
            $this->throwException('This job application has already been rejected.');
        }

        // Check if the user's company have this job in their list.
        $jobs = Job::where('company_id', auth()->user()->company_id)->lists('id')->toArray();

        if ( ! in_array($jobApplication->job_id, $jobs) ) {
            $this->throwException('This job does not belong to your company.');
        }

        return [
            //
        ];
    }

    private function throwException($message){
        $exception = new EmployerNeedsRolesException();
        $exception->setValidationErrors($message);

        throw $exception;
    }
}
