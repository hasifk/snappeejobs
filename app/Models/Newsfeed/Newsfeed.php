<?php

namespace App\Models\Newsfeed;

use App\Models\Newsfeed\Traits\Attribute\NewsfeedAttribute;

use Illuminate\Database\Eloquent\Model;

class Newsfeed extends Model
{
    use NewsfeedAttribute;
    
    protected $table = 'newsfeeds';

}
