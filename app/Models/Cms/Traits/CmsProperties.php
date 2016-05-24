<?php

namespace App\Models\Cms\Traits;


trait CmsProperties
{

    public function attachCMSImage($cmsFile)
    {

        if (is_null($cmsFile)) {
            return;
        }

        $filePath = "cms/admincms/" . $this->id . "/image/";
        $this->cms_filename= pathinfo($cmsFile->getClientOriginalName(), PATHINFO_FILENAME);
        $this->cms_extension=$cmsFile->getClientOriginalExtension();
        $this->cms_path=$filePath;
        $this->save();


        \Storage::deleteDirectory($filePath);

        \Storage::put($filePath . $cmsFile->getClientOriginalName(), file_get_contents($cmsFile));
        \Storage::setVisibility($filePath . $cmsFile->getClientOriginalName(), 'public');


// Resizing the cms images
        $avatar = $cmsFile;


        \Storage::disk('local')->put($filePath . $avatar->getClientOriginalName(), file_get_contents($avatar));

        foreach (config('image.thumbnails.blog_photo') as $image) {
            $cms_image= \Image::make($avatar);
        $cms_image->resize($image['width'], $image['height'])->save(storage_path('app/' . $filePath . pathinfo($avatar->getClientOriginalName(), PATHINFO_FILENAME) . $image['width'] . 'x' . $image['height'] . '.' . $avatar->getClientOriginalExtension()));
            \Storage::put($filePath . pathinfo($avatar->getClientOriginalName(), PATHINFO_FILENAME) . $image['width'] . 'x' . $image['height'] . '.' . $avatar->getClientOriginalExtension(), file_get_contents(storage_path('app/' . $filePath . pathinfo($avatar->getClientOriginalName(), PATHINFO_FILENAME) . $image['width'] . 'x' . $image['height'] . '.' . $avatar->getClientOriginalExtension())));
            \Storage::setVisibility($filePath . pathinfo($avatar->getClientOriginalName(), PATHINFO_FILENAME) . $image['width'] . 'x' . $image['height'] . '.' . $avatar->getClientOriginalExtension(), 'public');
        }

        \Storage::disk('local')->deleteDirectory($filePath);

    }


    public function detachCMSImage(){
        if ($this->cms_filename && $this->cms_extension && $this->cms_path) {

            foreach (config('image.thumbnails.blog_photo') as $image) {
                \Storage::delete($this->cms_path . $this->cms_filename . $image['width'] . 'x' . $image['height'].'.' . $this->cms_extension);
            }
            \Storage::delete($this->cms_path.$this->cms_filename.'.'.$this->cms_extension);
        }
    }
}