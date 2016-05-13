<?php namespace App\Repositories\Frontend\Blogs;


use App\Models\Blogs\Blogs;

use Auth;
use Storage;
/**
 * Class EloquentUserRepository
 * @package App\Repositories\User
 */
class EloquentBlogRepository
{

    public function getBlog($id){
        return Blogs::where('user_id', auth()->user()->id)->where('id', $id)->first();
    }

    public function getBlogs()
    {
        return Blogs::orderBy('Blogs.id', 'desc')
            ->paginate(10);
    }

    public function getNext($id)
    {
        $next =Blogs::where('blogs.id', '<>', $id)
            ->orderByRaw('RAND()')
            ->first();
        return $next;
    }

}