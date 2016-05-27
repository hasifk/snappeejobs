<?php namespace App\Repositories\Backend\Blogger;


use App\Models\Access\User\User;
use App\Models\Blogs\Blog;
use Carbon\Carbon;


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
    public function getBlogs()
    {
        return Blog::orderBy('id', 'desc')
            ->paginate(10);
    }

/*********************************************************************************************/
    public function approve($id) {
        $approval=Carbon::now();
        Blog::where('id',$id)->update(['approved_at' => $approval]);

            return true;
    }
    /*********************************************************************************************/
    public function disapprove($id) {

        Blog::where('id',$id)->update(['approved_at' => null]);

        return true;
    }
    /*********************************************************************************************/
}
