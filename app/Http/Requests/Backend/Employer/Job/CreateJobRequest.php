<?php

namespace App\Http\Requests\Backend\Employer\Job;

use App\Http\Requests\Request;

class CreateJobRequest extends Request
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
            'title'                 => 'required',
            'level'                 => 'required|in:internship,entry,mid,senior',
            'job_category'          => 'required|array',
            'skills'                => 'required|array',
            'description'           => 'required',
            'country_id'            => 'required',
            'state_id'              => 'required',
            'published'             => 'required',
        ];
    }

    public function messages(){
        return [
            'title.required'                => 'Title is required',
            'level.required'                => 'Level is required',
            'job_category.required'         => 'Any of the job category is required',
            'skills.required'               => 'Any of the job category is required',
            'description.required'          => 'Description is required',
            'country_id.required'           => 'Country is required',
            'state_id.required'             => 'State is required',
            'published.required'            => 'Published is required',
        ];
    }
}
