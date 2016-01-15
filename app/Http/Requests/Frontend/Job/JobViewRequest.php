<?php

namespace App\Http\Requests\Frontend\Job;

use App\Exceptions\Frontend\Job\JobDoesNotExist;
use App\Http\Requests\Request;
use App\Models\Company\Company;
use App\Models\Job\Job;

class JobViewRequest extends Request
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

        $jobExists = Job::join('companies', 'companies.id', '=', 'jobs.company_id')
            ->where('jobs.title_url_slug', $this->segment(3))
            ->where('jobs.status', true)
            ->where('jobs.published', true)
            ->where('companies.url_slug', $this->segment(2))
            ->count();

        if ( ! $jobExists ) {

            $exception = new JobDoesNotExist();
            $exception->setValidationErrors('We could not find the Job you are looking for');

            throw $exception;

        }

        return [

        ];
    }
}
