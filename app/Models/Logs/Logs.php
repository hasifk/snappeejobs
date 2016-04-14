<?php

namespace App\Models\Logs;

//use App\Models\Cms\Traits\Attribute\CmsAttribute;

use Illuminate\Database\Eloquent\Model;

class Logs extends Model
{
    //use CmsAttribute;
    
    protected $table = 'activity_log';

    protected $guarded = ['id'];
}
