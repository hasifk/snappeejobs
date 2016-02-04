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
            'job_categories'            => 'required|array',
            'skills'                    => 'required|array',
            'size'                      => 'required|in:small,medium,big',
        ];
    }

    public function messages(){
        return [
            'job_categories.required'           => 'Please enter the job categories',
            'skills.required'                   => 'Please enter the skills',
            'size.require'                      => 'Please select the company type preference'
        ];
    }
}
