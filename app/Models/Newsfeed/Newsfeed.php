<?php

namespace App\Models\Newsfeed;
use Illuminate\Database\Eloquent\Model;

class Newsfeed extends Model
{
    protected $table = 'newsfeeds';

    protected $guarded = ['id'];
}
