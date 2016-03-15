<?php

namespace App\Models\GroupMessage;

use Illuminate\Database\Eloquent\Model;

class GroupMessage extends Model
{
    protected $table = 'group_messages';

    protected $guarded = ['id'];

    public function mentions(){
        return $this->hasMany(GroupMessageMention::class, 'group_message_id');
    }
}
