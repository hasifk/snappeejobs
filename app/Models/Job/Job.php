<?php

namespace App\Models\Job;


use App\Models\Job\Traits\JobAttribute;
use App\Models\Job\Relationship\JobRelationship;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Job extends Model
{

    use SoftDeletes, JobAttribute, JobRelationship;

    protected $table = 'jobs';

    protected $guarded = ['id'];

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
}
