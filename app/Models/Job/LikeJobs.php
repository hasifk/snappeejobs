<?php

namespace App\Models\Job;


use Illuminate\Database\Eloquent\Model;

class LikeJobs extends Model
{



    protected $table;
    protected $guarded = ['id'];
    public function __construct()
    {
        $this->table = 'like_jobs';
    }
}
