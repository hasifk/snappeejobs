<?php

namespace App\Http\Requests\Backend\Employer\Settings;

use App\Exceptions\Backend\Access\Employer\Settings\SubscriptionPlanException;
use App\Http\Requests\Request;

class EmployerUpgradePlanRequest extends Request
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

        foreach (config('subscription.employer_plans') as $key=> $plans) {
            if($plans['id'] == $this->get('plan_id')){
                $new_plan_id = $key;
            }
            if($plans['id'] == auth()->user()->stripe_plan){
                $old_plan_id = $key;
            }
        }

        if($new_plan_id == ""){
            $this->throwException('Please select a valid plan',$this->get('subscription_plan_id'));
        }

        $key_new_plan = array_search($new_plan_id, array_keys(config('subscription.employer_plans')));

        $key_old_plan = array_search($old_plan_id, array_keys(config('subscription.employer_plans')));

        if($key_old_plan >= $key_new_plan){
            $this->throwException('Please select a higher plan',$this->get('subscription_plan_id'));
        }

        return [];
    }

    private function throwException($msg,$plan_id)
    {
        $exception = new SubscriptionPlanException();

        $exception->setValidationErrors($msg);

        $exception->setPlanID($plan_id);

        throw $exception;
    }

}
