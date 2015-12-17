<?php

namespace App\Http\Requests\Frontend;

use App\Http\Requests\Request;

class EmployerSignupRequest extends Request
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
            'name'	        => 'required',
            'email'	        => 'required|email',
            'company'	    => 'required',
            'country_id'	=> 'required',
            'state_id'	    => 'required',
        ];
    }

    public function messages(){
        return [
            'company.required'      => 'Company is required',
            'country_id.required'   => 'Country is requred',
            'state_id.required'     => 'State is requred',
        ];
    }
}
