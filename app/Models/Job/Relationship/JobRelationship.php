<?php

namespace App\Models\Job\Relationship;

use App\Models\Country\Country;
use App\Models\Job\JobApplication\JobApplication;
use App\Models\Job\JobPrerequisites\JobPrerequisites;
use App\Models\State\State;

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

    public function applications(){
        return $this->hasMany(JobApplication::class, 'job_id');
    }

    public function country(){
        return $this->belongsTo(Country::class);
    }

    public function state(){
        return $this->belongsTo(State::class);
    }

}
