<?php

namespace App\Models\Job\Category;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table;
    protected $guarded = ['id'];
    public function __construct()
    {
        $this->table = 'job_categories';
    }
}
