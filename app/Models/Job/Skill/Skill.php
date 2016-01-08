<?php

namespace App\Models\Job\Skill;

use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    protected $table;
    protected $guarded = ['id'];
    public function __construct()
    {
        $this->table = 'skills';
    }
}
