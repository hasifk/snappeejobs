<?php

namespace App\Models\Task;

use App\Models\Access\User\User;
use Illuminate\Database\Eloquent\Model;

class TaskMember extends Model
{
    protected $table = 'staff_task';
    protected $guarded = ['id'];
    protected $dates = ['created_at', 'updated_at'];

    public function user() {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
