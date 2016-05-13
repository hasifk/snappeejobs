<?php

namespace App\Models\Blogs;



use Illuminate\Database\Eloquent\Model;
use Storage;
class Blogs extends Model
{


    protected $table = 'Blogs';

    protected $guarded = ['id'];

    public function getCategorynameAttribute(){
        return \DB::table('blog_categories')->where('id', $this->blog_category_id)->value('name');
    }

    public function getSubcategorynameAttribute(){
        return \DB::table('blog_sub_cats')->where('id', $this->blog_sub_cat_id)->value('name');
    }
    
    public function getvideolinkAttribute(){
        if ($this->youtube_id) {
            return 'https://www.youtube.com/watch?v='.$this->youtube_id;
        } else if ($this->vimeo_id) {
            return 'https://vimeo.com/'.$this->vimeo_id;
        } else {
            return '';
        }
    }

    private function editLink() {
        return '<a href="'.route('Blogs.edit', $this->id).'" class="btn btn-xs btn-primary"><i class="fa fa-pencil" data-toggle="tooltip" data-placement="top" title="Edit"></i></a>';;
    }
    private function deleteLink() {
        return '<a href="'.route('Blogs.delete', $this->id).'" class="blog_delete btn btn-xs btn-danger"><i class="fa fa-trash" data-toggle="tooltip" data-placement="top" title="Delete"></i></a>';;
    }

    public function getActionButtonsAttribute(){
        return $this->editLink().$this->deleteLink();
    }

    public function getAuthorAttribute(){
        return \DB::table('users')->where('id', $this->user_id)->value('name');
    }

    public function getImagethumbAttribute($width = 25, $height = 25){
        if ($this->avatar_filename && $this->avatar_extension && $this->avatar_path) {
            return '<img src="'.
            'https://s3-'. env('AWS_S3_REGION', 'eu-west-1') .'.amazonaws.com/'.
            env('AWS_S3_BUCKET', 'snappeejobs').'/'.
            $this->avatar_path.$this->avatar_filename.$width.'x'.$height.'.'.$this->avatar_extension .
            '" alt="image" style="height: '.$height.'px; width: '.$width.'px;">';
        } else {
            return '';
        }
    }

    public function getImageAttribute(){
        if ($this->avatar_filename && $this->avatar_extension && $this->avatar_path) {
            return '<img src="'.
            'https://s3-'. env('AWS_S3_REGION', 'eu-west-1') .'.amazonaws.com/'.
            env('AWS_S3_BUCKET', 'snappeejobs').'/'.
            $this->avatar_path.$this->avatar_filename.'750x350.'.$this->avatar_extension .
            '" alt="image" style="height: 350px; width: 750px;">';
        } else {
            return '';
        }
    }
    public function detachImage(){
        if ($this->avatar_filename && $this->avatar_extension && $this->avatar_path) {
            Storage::delete($this->avatar_path.$this->avatar_filename.'750x350.'.$this->avatar_extension);
            Storage::delete($this->avatar_path.$this->avatar_filename.'297x218.'.$this->avatar_extension);
            Storage::delete($this->avatar_path.$this->avatar_filename.'25x25.'.$this->avatar_extension);
            Storage::delete($this->avatar_path.$this->avatar_filename.'.'.$this->avatar_extension);
        }
    }
}
