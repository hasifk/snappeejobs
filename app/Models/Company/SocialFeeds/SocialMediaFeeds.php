<?php

namespace App\Models\Company\SocialFeeds;

use App\Models\Company\Photo\Traits\Attribute\PhotoAttribute;
use Illuminate\Database\Eloquent\Model;

class SocialMediaFeeds extends Model
{

    use PhotoAttribute;

    protected $table = 'social_media_feeds';

    protected $guarded = ['id'];

}
