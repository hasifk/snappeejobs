<?php namespace App\Exceptions\Backend\Project;

/**
 * Class MessageDoesNotBelongToUser
 * @package App\Exceptions\Access
 */
class ProjectDoesNotBelongToUser extends \Exception {

    /**
     * @var
     */
    protected $user_id;
    /**
     * @var
     */
    protected $errors;

    /**
     * @param $user_id
     */
    public function setUserID($user_id)
    {
        $this->user_id = $user_id;
    }

    /**
     * @return mixed
     */
    public function userID()
    {
        return $this->user_id;
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