<?php

namespace App\Models\Cms;

use App\Models\Cms\Traits\Attribute\CmsAttribute;

use App\Models\Cms\Traits\CmsProperties;
use Illuminate\Database\Eloquent\Model;

class Cms extends Model
{
    use CmsAttribute,CmsProperties;
    
    protected $table = 'cms';

    protected $guarded = ['id'];
}
