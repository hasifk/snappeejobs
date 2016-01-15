<?php

namespace App\Models\Job\Relationship;

use App\Models\Job\JobPrerequisites\JobPrerequisites;

trait JobRelationship
{
    public function company(){
        return $this->hasOne('App\Models\Company\Company', 'id', 'company_id');
    }

    public function categories(){
        return $this->belongsToMany(
            'App\Models\Job\Category\Category', 'category_preferences_jobs', 'job_id', 'job_category_id'
        );
    }

    public function skills(){
        return $this->belongsToMany(
            'App\Models\Job\Skill\Skill', 'job_skills', 'job_id', 'skill_id'
        );
    }

    public function prerequisites(){
        return $this->hasMany(JobPrerequisites::class, 'job_id');
    }

}