<?php

namespace App\Models\JobSeeker;

use Illuminate\Database\Eloquent\Model;

class JobSeeker extends Model
{
    protected $table = 'job_seeker_details';

    protected $guarded = ['id'];

    public function user(){
        return $this->hasOne('App\Models\Access\User\User', 'id', 'user_id');
    }

    public function skills(){
        return $this->belongsToMany(
            'App\Models\Job\Skill\Skill', 'skills_job_seeker', 'user_id', 'skill_id'
        );
    }

}
