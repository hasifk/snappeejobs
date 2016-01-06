<?php

namespace App\Http\Requests\Backend\Employer\Mail;

use App\Http\Requests\Request;

class EmployerMailInboxView extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return access()->can('mail-view-private-messages');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
        ];
    }
}
