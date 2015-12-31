<?php

namespace App\Models\Company\Traits;


use App\Models\Company\People\People;
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

    public function attachPeople($people_names, $job_positions, $people_about, $people_testimonial, $avatar_image, $people_id, $people_delete, $people_avatars){

        foreach ($people_names as $key => $people_name) {

            if ( $people_name ) {

                if ( $people_delete && in_array($people_id[$key], $people_delete) ) {
                    $peopleModel = $this->people()->where('id', $people_id[$key])->first();

                    \Storage::deleteDirectory("companies/" . $this->id."/people/". $peopleModel->id);

                    $peopleModel->delete();

                    continue;
                }

                if ( $people_id[$key] ) {
                    $this->people()->where('id', $people_id[$key])->update(
                        [
                            'name'          => $people_name,
                            'designation'   => $job_positions[$key],
                            'about_me'      => $people_about[$key],
                            'testimonial'   => $people_testimonial[$key],
                        ]
                    );
                    $peopleModel = $this->people()->where('id', $people_id[$key])->first();

                } else {
                    $people = new People([
                        'name'          => $people_name,
                        'designation'   => $job_positions[$key],
                        'about_me'      => $people_about[$key],
                        'testimonial'   => $people_testimonial[$key],
                    ]);

                    $peopleModel = $this->people()->save($people);
                }

                if ( $people_avatars[$key] && $people_avatars[$key]->isValid() ) {

                    if ( $avatar_image[$key] ) { // Delete the old file
                        \Storage::deleteDirectory("companies/" . $this->id."/people/". $peopleModel->id);
                    }

                    $avatar = $people_avatars[$key];

                    $filePath = "companies/" . $this->id."/people/". $peopleModel->id ."/avatar/";
                    \Storage::put($filePath. $avatar->getClientOriginalName() , file_get_contents($avatar));
                    \Storage::setVisibility($filePath. $avatar->getClientOriginalName(), 'public');

                    $peopleModel->update([
                        'filename' => pathinfo($avatar->getClientOriginalName(), PATHINFO_FILENAME),
                        'extension' => $avatar->getClientOriginalExtension(),
                        'path' => $filePath
                    ]);
                }
            }
        }
    }

    public function detachPeople($people){

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