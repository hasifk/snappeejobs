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

    public function getBlogs($category_slug = '', $sub_category_slug = '')
    {
        $blogsObject = Blogs::whereNotNull('title');
        if ( $category_slug ) {
            $category_id = \DB::table('blog_categories')->where('url_slug', $category_slug)->value('id');
            $blogsObject->where('blog_category_id', $category_id);
        }
        if ( $sub_category_slug ) {
            $sub_category_id = \DB::table('blog_sub_cats')->where('url_slug', $sub_category_slug)->value('id');
            $blogsObject->where('blog_sub_cat_id', $sub_category_id);
        }

        $blogs = $blogsObject->orderBy('blogs.id', 'desc')
            ->paginate(10);

        return $blogs;
    }

    public function getNext($id)
    {
        $next =Blogs::where('blogs.id', '<>', $id)
            ->orderByRaw('RAND()')
            ->first();
        return $next;
    }

}