<?php

namespace App\Http\Requests\Frontend\Job;

use App\Exceptions\Frontend\Job\JobDoesNotExist;
use App\Http\Requests\Request;

class ApplyJob extends Request
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
        $companyId = $this->get('companyId');
        $jobId = $this->get('jobId');

        $jobExists = \DB::table('jobs')
            ->where('id', $jobId)
            ->where('company_id', $companyId)
            ->where('status', true)
            ->where('published', true)
            ->count();

        if (! $jobExists ) {
            $exception = new JobDoesNotExist();
            $exception->setValidationErrors('We could not find the Job you are looking for');

            throw $exception;
        }

        return [
            //
        ];
    }
}
