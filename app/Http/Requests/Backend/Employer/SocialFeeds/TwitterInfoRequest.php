<?php

namespace App\Http\Requests\Backend\Employer\SocialFeeds;

use App\Http\Requests\Request;

class TwitterInfoRequest extends Request
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
            'tw_screen_name'                 => 'required',
        ];
    }

    public function messages(){
        return [
            'tw_screen_name.required'                => 'Please Enter a Twitter Screenname'


        ];
    }



}
