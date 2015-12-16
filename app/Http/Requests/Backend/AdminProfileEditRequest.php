<?php

namespace App\Http\Requests\Backend;

use App\Http\Requests\Request;

class AdminProfileEditRequest extends Request
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
            'name'                  => 'required',
            'password'              => 'alpha_num|min:6|confirmed',
            'password_confirmation' => 'alpha_num|min:6',
            'avatar'                => 'image|max:1024|mimes:jpeg,jpg,png'
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'avatar.max' => 'Avatar image may not be more than :max KB'
        ];
    }

}
