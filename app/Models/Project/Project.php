<?php

namespace App\Models\Project;

use App\Models\Project\Project\Traits\Attribute\ProjectAttribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{

    use ProjectAttribute, SoftDeletes;

    protected $table = 'projects';
    protected $guarded = ['id'];
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function members(){
        return $this->hasMany(ProjectMember::class, 'project_id');
    }

    public function job_listings(){
        return $this->hasMany(ProjectJobListing::class, 'project_id');
    }

}
