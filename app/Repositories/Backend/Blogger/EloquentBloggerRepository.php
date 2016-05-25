<?php namespace App\Repositories\Backend\Blogger;


use App\Models\Access\User\User;
use App\Models\Blogs\Blogs;
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
        return Blogs::orderBy('Blogs.id', 'desc')
            ->paginate(10);
    }

/*********************************************************************************************/
    public function storeApproval($request)
    {
        if($request->approval==1):
            $approval=Carbon::now();
            else:
                $approval=null;
            endif;
       Blogs::where('id',$request->id)->update(['approved_at' => $approval]);
        return true;
    }

    /*********************************************************************************************/

}
