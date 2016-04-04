<?php

namespace App\Models\Project\Relationship;

use App\Models\Access\User\User;
use App\Models\Project\ProjectJobListing;
use App\Models\Project\ProjectMember;
use App\Models\Task\Task;

trait ProjectRelationship
{

    public function tasks(){
        return $this->hasMany(Task::class, 'project_id');
    }

    public function members(){
        return $this->hasMany(ProjectMember::class, 'project_id');
    }

    public function job_listings(){
        return $this->hasMany(ProjectJobListing::class, 'project_id');
    }

}
