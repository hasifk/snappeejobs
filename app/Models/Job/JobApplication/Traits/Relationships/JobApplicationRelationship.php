<?php

namespace App\Models\Job\JobApplication\Traits\Relationships;

use App\Models\Access\User\User;
use App\Models\Job\Job;

trait JobApplicationRelationship
{
    public function job(){
        return $this->hasOne(Job::class, 'id', 'job_id');
    }

    public function jobseeker(){
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
