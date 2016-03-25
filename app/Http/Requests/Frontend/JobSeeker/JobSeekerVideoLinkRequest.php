<?php

namespace App\Http\Requests\Frontend\JobSeeker;

use App\Http\Requests\Request;

class JobSeekerVideoLinkRequest extends Request
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
            'videolink'                 => 'required|youtube_vimeo',
        ];
    }

    public function messages(){
        return [
            'videolink.required'                => 'Youtube/vimeo Field cannot be empty',
            'videolink.youtube_vimeo'                => 'Please enter a valid Youtube/vimeo link'


        ];
    }



}
