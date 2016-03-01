<?php

namespace App\Http\Requests\Backend\Employer\Settings;


use App\Http\Requests\Request;

class MakeCompanyPaidRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return access()->can('employer-settings');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        return [
            'select_company' => 'required|min:1'
        ];
    }
}
