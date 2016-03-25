<?php

namespace App\Models\JobSeeker\Traits\Attribute;




trait VideoLinkAttribute
{



    public function setYoutubeIdAttribute($value)
    {
        $this->attributes['youtube_id'] = $value ?: null;
    }
/*************************************************************************************************/
    public function setVimeoIdAttribute($value)
    {
        $this->attributes['vimeo_id'] = $value ?: null;
    }
/*************************************************************************************************/
}