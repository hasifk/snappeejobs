<?php

namespace App\Models\Cms;

use App\Models\Cms\Traits\Attribute\CmsAttribute;

use Illuminate\Database\Eloquent\Model;

class Cms extends Model
{
    use CmsAttribute;
    
    protected $table = 'cms';

    protected $guarded = ['id'];
}
