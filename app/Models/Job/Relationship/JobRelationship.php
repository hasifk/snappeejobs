<?php

namespace App\Models\Job\Relationship;


use App\Models\Company\Company;
use App\Models\Job\JobPrerequisites\JobPrerequisites;

trait JobRelationship
{
    public function company(){
        return $this->hasOne(Company::class, 'id', 'company_id');
    }

    public function categories(){
        return $this->belongsToMany(
            'App\Models\Job\Category\Category', 'category_preferences_jobs', 'job_id', 'job_category_id'
        );
    }
    
    public function prerequisites(){
        return $this->hasMany(JobPrerequisites::class);
    }

}