<?php

namespace App\Http\Requests\Backend\Employer\Job;

use App\Exceptions\Frontend\Job\JobDoesNotExist;
use App\Http\Requests\Request;
use Carbon\Carbon;

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

        // Find the number of jobs posted this month
        $totalJobsPostedThisMonth = \DB::table('jobs')
            ->join('companies', 'companies.id', '=', 'jobs.company_id')
            ->where('companies.employer_id', auth()->user()->employer_id)
            ->where('jobs.created_at', '>=', Carbon::now()->startOfMonth() )
            ->where('jobs.created_at', '<=', Carbon::now()->endOfMonth() )
            ->whereNull('jobs.deleted_at')
            ->count();

        if ( auth()->user()->employerPlan && $totalJobsPostedThisMonth >= auth()->user()->employerPlan->job_postings ) {
            $exception = new JobDoesNotExist();
            $exception->setValidationErrors('You have exceeded the limit of jobs allotted for this month.');
            throw $exception;
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
