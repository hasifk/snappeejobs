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

    public function getBlog($id){
        return Blogs::where('user_id', auth()->user()->id)->where('id', $id)->first();
    }

    public function getBlogs()
    {
        return Blogs::where('user_id', Auth::user()->id)->orderBy('Blogs.id', 'desc')
            ->paginate(10);
    }
    public function save($request)
    {
        $userid = Auth::user()->id;

        if ($request->has('id'))
            $obj = Blogs::find($request->id);
        else {
            $obj = new Blogs();
            $obj->user_id = $userid;
        }
        $obj->title = $request->title;
        $obj->content = $request->content;
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


        $avatar = $request->file('file');

        if ( $avatar && $avatar->isValid() ) {

            // Delete the old image.
            if ($request->has('id') && $obj->avatar_filename && $obj->avatar_extension && $obj->avatar_path ) {
                if ( \Storage::has($obj->avatar_path.$obj->avatar_filename.'.'.$obj->avatar_extension) ) {
                    \Storage::delete($obj->avatar_path.$obj->avatar_filename.'.'.$obj->avatar_extension);
                    foreach (config('image.thumbnails.blog_photo') as $image) {
                        \Storage::delete($obj->avatar_path.$obj->avatar_filename.$image['width'].'x'.$image['height'].'.'.$obj->avatar_extension );
                    }
                }
            }

            $filePath = "cms/" . $obj->id ."/avatar/";
            Storage::put($filePath. $avatar->getClientOriginalName() , file_get_contents($avatar));
            Storage::setVisibility($filePath. $avatar->getClientOriginalName(), 'public');

            $obj->avatar_filename = pathinfo($avatar->getClientOriginalName(), PATHINFO_FILENAME);
            $obj->avatar_extension = $avatar->getClientOriginalExtension();
            $obj->avatar_path = $filePath;
            $obj->save();

            // Resize User Profile Image
            $profile_image = \Image::make($avatar);

            \Storage::disk('local')->put($filePath.$avatar->getClientOriginalName(), file_get_contents($avatar));

            foreach (config('image.thumbnails.blog_photo') as $image) {
                $profile_image->resize($image['width'], $image['height'])->save( storage_path('app/' .$filePath.pathinfo($avatar->getClientOriginalName(), PATHINFO_FILENAME).$image['width'].'x'.$image['height'].'.'.$avatar->getClientOriginalExtension() ) );
                \Storage::put($filePath.pathinfo($avatar->getClientOriginalName(), PATHINFO_FILENAME).$image['width'].'x'.$image['height'].'.'.$avatar->getClientOriginalExtension() , file_get_contents( storage_path('app/' .$filePath.pathinfo($avatar->getClientOriginalName(), PATHINFO_FILENAME).$image['width'].'x'.$image['height'].'.'.$avatar->getClientOriginalExtension() ) ) );
                \Storage::setVisibility($filePath.pathinfo($avatar->getClientOriginalName(), PATHINFO_FILENAME).$image['width'].'x'.$image['height'].'.'.$avatar->getClientOriginalExtension(), 'public');
            }

            \Storage::disk('local')->deleteDirectory($filePath);

        }

        return 'success';


    }


}