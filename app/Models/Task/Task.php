<?php

namespace App\Models\Task;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $table = 'task_project';
    protected $guarded = ['id'];
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
}
