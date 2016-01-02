<?php

namespace App\Models\Job;


use App\Models\Job\Traits\JobAttribute;
use App\Models\Job\Relationship\JobRelationship;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{

    use JobAttribute, JobRelationship;

    protected $table = 'jobs';

    protected $guarded = ['id'];
}
