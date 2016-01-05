<?php

namespace App\Models\Mail\Message;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $table = 'messages';

    protected $guarded = ['id'];

    protected $dates = ['created_at', 'updated_at'];
}
