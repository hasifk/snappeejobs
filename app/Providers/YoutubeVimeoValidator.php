<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Validator;

class YoutubeVimeoValidator extends ServiceProvider {

    public function boot()
    {
        Validator::extend('youtube_vimeo', function($attribute, $value, $parameters) {
            if (strpos($value, 'youtube') > 0) {
                return true;
            } elseif (strpos($value, 'vimeo') > 0) {
                return true;
            } else {
                return false;
            }
        });
    }



    public function register()
    {
        //
    }
}


