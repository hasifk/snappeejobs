<?php

namespace App\Models\Job;


use Illuminate\Database\Eloquent\Model;

class DisLikeJobs extends Model
{



    protected $table;
    protected $guarded = ['id'];
    public function __construct()
    {
        $this->table = 'dislike_jobs';
    }
}
