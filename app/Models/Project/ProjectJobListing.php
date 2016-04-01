<?php

namespace App\Models\Project;

use Illuminate\Database\Eloquent\Model;

class ProjectJobListing extends Model
{
    protected $table = 'job_listing_project';
    protected $guarded = ['id'];
    protected $dates = ['created_at', 'updated_at'];
}
