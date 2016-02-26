<?php

namespace App\Http\Requests\Backend\Employer\Settings;

use App\Exceptions\Backend\Access\Employer\Settings\SubscriptionPlanException;
use App\Http\Requests\Request;

class EmployerBuyAddonRequest extends Request
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

        $addons = ['job_postings', 'staff_members', 'chats_accepted'];

        if ( ! in_array($this->segment(5), $addons) ) {
            $exception = new SubscriptionPlanException();
            $exception->setValidationErrors('Please select a correct addon');
            throw $exception;
        }

        return [
            'addonvalue' => 'required|numeric'
        ];
    }
}
