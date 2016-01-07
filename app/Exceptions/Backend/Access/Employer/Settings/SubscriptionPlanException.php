<?php namespace App\Exceptions\Backend\Access\Employer\Settings;


class SubscriptionPlanException extends \Exception
{
    /**
     * @var
     */
    protected $plan_id;
    /**
     * @var
     */
    protected $errors;

    /**
     * @param $user_id
     */
    public function setPlanID($plan_id)
    {
        $this->plan_id = $plan_id;
    }

    /**
     * @return mixed
     */
    public function planID()
    {
        return $this->plan_id;
    }

    /**
     * @param $errors
     */
    public function setValidationErrors($errors)
    {
        $this->errors = $errors;
    }

    /**
     * @return mixed
     */
    public function validationErrors()
    {
        return $this->errors;
    }
}