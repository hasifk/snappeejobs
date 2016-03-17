<?php

namespace App\Http\Requests\Backend\Admin\Mail;

use App\Http\Requests\Request;

class AdminMailSendMessageRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return access()->can('message-employers');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'company'   => 'required',
            'to'        => 'required',
            'subject'   => 'required',
            'message'   => 'required'
        ];
    }
}
