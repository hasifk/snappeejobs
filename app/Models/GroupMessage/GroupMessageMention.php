<?php

namespace App\Models\GroupMessage;

use Illuminate\Database\Eloquent\Model;

class GroupMessageMention extends Model
{
    protected $table = 'group_message_mentions';

    protected $guarded = ['id'];
}
