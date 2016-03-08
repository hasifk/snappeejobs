<?php namespace App\Exceptions\Frontend\Profile;

/**
 * Class MessageDoesNotBelongToUser
 * @package App\Exceptions\Access
 */
class ThreadDoesNotExists extends \Exception {


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