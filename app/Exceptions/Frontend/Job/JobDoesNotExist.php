<?php namespace App\Exceptions\Frontend\Job;

/**
 * Class MessageDoesNotBelongToUser
 * @package App\Exceptions\Access
 */
class JobDoesNotExist extends \Exception {

    /**
     * @var
     */
    protected $errors;


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