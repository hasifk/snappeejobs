<?php

namespace App\Models\Task;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $table = 'task_project';
    protected $guarded = ['id'];
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function members() {
        return $this->hasMany(TaskMember::class, 'task_id');
    }

    public function getProjectnameAttribute() {
        return \DB::table('projects')->where('id', $this->attributes['project_id'])->value('title');
    }

    public function getAllmembersAttribute(){
        $members_array = \DB::table('users')->whereIn('id', $this->members()->lists('user_id')->toArray())->lists('name');
        return implode(' , ', $members_array);
    }

}
