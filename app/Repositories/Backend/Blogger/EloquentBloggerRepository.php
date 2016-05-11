<?php namespace App\Repositories\Backend\Blogger;


use App\Models\Access\User\User;


/**
 * Class EloquentUserRepository
 * @package App\Repositories\User
 */
class EloquentBloggerRepository {


    public function getUsers()
    {

        return User::whereNotIn('id',array(auth()->user()->id))->paginate(10);



    }

/****************************************************************************************************/



}
