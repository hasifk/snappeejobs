<?php

namespace App\Models\Company\Traits;


use App\Models\Company\SocialMediaCompany\SocialMediaCompany;
use App\Models\Company\Video\Video;

trait CompanyProperties
{

    public function attachIndustries($industries){
        foreach ($industries as $industry) {
            $this->attachIndustry($industry);
        }
    }

    public function detachIndustries($industries){
        foreach ($industries as $industry) {
            $this->detachIndustry($industry);
        }
    }

    public function attachSocialMedia($social_media){
        foreach ($social_media as $social_media_item) {
            if ( ! empty($social_media_item) ) {
                $this->attachSocialMediaItem($social_media_item);
            }
        }
    }

    public function attachVideos($videos){
        foreach ($videos as $video) {
            if ( ! empty($video) ) {
                $this->attachVideo($video);
            }
        }
    }

    public function detachSocialMedia($social_media){
        \DB::table('socialmediainfo_company')->where('company_id', $this->id)->delete();
    }

    public function detachVideos($videos){
        \DB::table('videos_company')->where('company_id', $this->id)->delete();
    }

    public function attachIndustry($industry)
    {
        if( is_object($industry))
            $industry = $industry->getKey();

        if( is_array($industry))
            $industry = $industry['id'];

        $this->industries()->attach($industry);
    }

    public function detachIndustry($industry)
    {
        if( is_object($industry))
            $industry = $industry->getKey();

        if( is_array($industry))
            $industry = $industry['id'];

        $this->industries()->detach($industry);
    }

    public function attachSocialMediaItem($item){
        $item = new SocialMediaCompany(['url' => $item]);
        $this->socialmedia()->save($item);
    }

    public function detachSocialMediaItem($item){
        $item = ['url' => $item];
        $this->socialmedia()->detach($item);
    }

    public function attachVideo($video){
        $video = new Video(['url' => $video]);
        $this->videos()->save($video);
    }


}