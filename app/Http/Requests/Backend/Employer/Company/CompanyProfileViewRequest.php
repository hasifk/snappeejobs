<?php

namespace App\Http\Requests\Backend\Employer\Company;

use App\Http\Requests\Request;

class CompanyProfileViewRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return access()->can('company-profile-view');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [

        ];
    }
}
