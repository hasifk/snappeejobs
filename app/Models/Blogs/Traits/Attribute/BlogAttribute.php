<?php namespace App\Models\Blogs\Traits\Attribute;

use Storage;
Trait BlogAttribute
{

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

    public function getImagethumbAttribute($width, $height){
        if ($this->avatar_filename && $this->avatar_extension && $this->avatar_path) {
            return '<img src="'.
            'https://s3-'. env('AWS_S3_REGION', 'eu-west-1') .'.amazonaws.com/'.
            env('AWS_S3_BUCKET', 'snappeejobs').'/'.
            $this->avatar_path.$this->avatar_filename.$width.'x'.$height.'.'.$this->avatar_extension .
            '" alt="image" style="height: '.$height.'px; width: '.$width.'px;">';
        } else {
            return '<img src="'.'https://placeholdit.imgix.net/~text?txtsize=28&txt='.$width.'%C3%97'.$height.'&w='.$width.'&h='.$height.'">';
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
            return '<img src="'.'https://placeholdit.imgix.net/~text?txtsize=28&txt=750%C3%97350&w=750&h=350'.'">';
        }
    }

    public function getAuthorimageAttribute($width = 90, $height = 90, $class = 'img-circle'){
        $width = 90;
        $author = \DB::table('users')->where('id', $this->user_id)->first(['avatar_filename', 'avatar_extension', 'avatar_path']);
        if ($author->avatar_filename && $author->avatar_extension && $author->avatar_path) {
            return '<img class="'. $class .'" src="'.
            'https://s3-'. env('AWS_S3_REGION', 'eu-west-1') .'.amazonaws.com/'.
            env('AWS_S3_BUCKET', 'snappeejobs').'/'.
            $author->avatar_path.$author->avatar_filename.$width.'x'.$height.'.'.$author->avatar_extension .
            '" alt="image">';
        } else {
            return '';
        }
    }

    public function getAuthoraboutmeAttribute() {
        return \DB::table('users')->where('id', $this->user_id)->value('about_me');
    }

    public function detachImage(){
        if ($this->avatar_filename && $this->avatar_extension && $this->avatar_path) {
            foreach (config('image.thumbnails.blog_photo') as $image) {
                Storage::delete($this->avatar_path . $this->avatar_filename . $image['width'] . 'x' . $image['height'].'.' . $this->avatar_extension);
            }

            Storage::delete($this->avatar_path.$this->avatar_filename.'.'.$this->avatar_extension);
        }
    }


    public function getApprovedButtonAttribute(){
        if ( $this->approved_at!=null ) {
            return '<a href="'.route('backend.blogdisapprove', [$this->id]).'" class="btn btn-xs btn-warning"><i class="fa fa-pause" data-toggle="tooltip" data-placement="top" title="Disapprove"></i></a> ';
        } else {
            return '<a href="'.route('backend.blogapprove', [$this->id]).'" class="btn btn-xs btn-info"><i class="fa fa-eye" data-toggle="tooltip" data-placement="top" title="Approve"></i></a> ';
        }
    }
}