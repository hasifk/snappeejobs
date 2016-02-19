<?php

namespace App\Models\Job\JobApplication;

use App\Models\Job\JobApplication\Traits\Attribute\JobApplicationAttribute;
use App\Models\Job\JobApplication\Traits\Relationships\JobApplicationRelationship;
use Illuminate\Database\Eloquent\Model;

class JobApplication extends Model
{

    use JobApplicationRelationship, JobApplicationAttribute;

    protected $table;
    protected $guarded = ['id'];
    public function __construct()
    {
        $this->table = 'job_applications';
    }
}
