<?php

namespace App\Models\Project;

use App\Models\Access\User\User;
use Illuminate\Database\Eloquent\Model;

class ProjectMember extends Model
{
    protected $table = 'members_project';
    protected $guarded = ['id'];
    protected $dates = ['created_at', 'updated_at'];

    public function user(){
        return $this->hasOne(User::class);
    }
}
