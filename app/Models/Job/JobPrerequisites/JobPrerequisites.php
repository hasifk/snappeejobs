<?php

namespace App\Models\Job\JobPrerequisites;

use Illuminate\Database\Eloquent\Model;

class JobPrerequisites extends Model
{
    protected $table;
    protected $guarded = ['id'];
    public function __construct()
    {
        $this->table = 'job_prerequisites';
    }
}
