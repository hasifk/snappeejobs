<?php namespace App\Repositories\Frontend\Blogs;


use App\Models\Blogs\Blog;

use Auth;
use Storage;
/**
 * Class EloquentUserRepository
 * @package App\Repositories\User
 */
class EloquentBlogRepository
{

    public function getBlog($id){
        if ( access()->hasRole('Administrator') ) {
            return Blog::where('id', $id)->first();
        }
        else
        {
            return Blog::where('id', $id)->where('approved_at', '!=', 'null')->first();
        }
    }

    public function getBlogs($category_slug = '', $sub_category_slug = '')
    {
        $blogsObject = Blog::whereNotNull('title');
        if ( $category_slug ) {
            $category_id = \DB::table('blog_categories')->where('url_slug', $category_slug)->value('id');
            $blogsObject->where('blog_category_id', $category_id);
        }
        if ( $sub_category_slug ) {
            $sub_category_id = \DB::table('blog_sub_cats')->where('url_slug', $sub_category_slug)->value('id');
            $blogsObject->where('blog_sub_cat_id', $sub_category_id);
        }

        $blogs = $blogsObject->orderBy('id', 'desc')
            ->paginate(10);

        return $blogs;
    }

}