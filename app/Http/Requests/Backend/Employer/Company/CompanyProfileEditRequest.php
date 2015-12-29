<?php

namespace App\Http\Requests\Backend\Employer\Company;

use App\Http\Requests\Request;

class CompanyProfileEditRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return access()->can('company-profile-edit');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title'         => 'required',
            'size'          => 'required,in:small,medium,big',
            'industries'    => 'required',
            'description'   => 'required',
            'what_it_does'  => 'required',
            'office_life'   => 'required',
            'country_id'    => 'required',
            'state_id'      => 'required',
        ];
    }
}
