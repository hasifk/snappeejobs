<?php

namespace App\Models\Task;

use Illuminate\Database\Eloquent\Model;

class TaskMember extends Model
{
    protected $table = 'staff_task';
    protected $guarded = ['id'];
    protected $dates = ['created_at', 'updated_at'];
}
