<?php namespace App\Repositories\Backend\Blogs;


use App\Models\Blogs\Blogs;

use Auth;
use Storage;
/**
 * Class EloquentUserRepository
 * @package App\Repositories\User
 */
class EloquentBlogRepository
{
    public function getBlogs()
    {
        return Blogs::where('user_id', Auth::user()->id)->orderBy('blogs.id', 'desc')
            ->paginate(10);
    }
    public function save($request)
    {
        $userid = Auth::user()->id;

        if ($request->has('id'))
            $obj = $this->find($request->id);
        else {
            $obj = new Blogs();
            $obj->user_id = $userid;
        }
        $obj->author = $request->author;
        if (!empty($request->image)):
            $avatar = $request->image;
            if ($avatar->isValid()) {
                $filePath = "cms/" . $userid . '/';
                $extension = $avatar->getClientOriginalExtension(); // getting image extension

                $fileName = rand(11111, 99999) .time(). '.' . $extension; // rename image

                Storage::put($filePath . $fileName, file_get_contents($avatar));
                Storage::setVisibility($filePath . $fileName, 'public');

                $obj->image = $filePath . $fileName;
            }
        endif;
        if (!empty($request->author_img)):
            $avatar1 = $request->author_img;
            if ($avatar1->isValid()) {
                $filePath = "cms/" . $userid . '/';
                $extension = $avatar1->getClientOriginalExtension(); // getting image extension

                $fileName = rand(11111, 99999) .time(). '.' . $extension; // rename image

                Storage::put($filePath . $fileName, file_get_contents($avatar));
                Storage::setVisibility($filePath . $fileName, 'public');

                $obj->avatar_filename = $filePath . $fileName;
            }
        endif;


            $link=$request->videolink;
            $youtube_id=$vimeo_id='';
            if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $link, $match))
            {
                $youtube_id=$match[1];
            }
            if (preg_match('/(https?:\/\/)?(www\.)?(player\.)?vimeo\.com\/([a-z]*\/)*([0-9]{6,11})[?]?.*/', $link, $match))
            {
                $vimeo_id = $match[5];
            }
            $obj->blog_category_id = $request->blog_category;
            $obj->blog_sub_cat_id = $request->content;
            $obj->blog_sub_cat_id = $request->blog_sub_cat;
            $obj->youtube_id = $youtube_id;
            $obj->vimeo_id = $vimeo_id;

            $obj->save();
            return 'success';




    }


}