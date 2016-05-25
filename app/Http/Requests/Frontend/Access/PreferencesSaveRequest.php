<?php

namespace App\Http\Requests\Frontend\Access;

use App\Http\Requests\Request;

class PreferencesSaveRequest extends Request
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
        return [
            'skills'                    => 'required|array',
            'job_categories'            => 'required|array',
            'industries'                => 'required|array',
            'size'                      => 'required|in:small,medium,big',
        ];
    }

    public function messages(){
        return [
            'skills.required'                   => 'Please enter the skills',
            'job_categories.required'           => 'Please enter the job categories',
            'industries.required'               => 'Please enter the Preffered Industries',
            'size.require'                      => 'Please select the company type preference'
        ];
    }
}
