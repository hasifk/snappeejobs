<?php

namespace App\Models\Mail\Message;

use App\Models\Mail\Message\Relationship\MessageRelationship;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use MessageRelationship;

    protected $table = 'messages';

    protected $guarded = ['id'];

    protected $dates = ['created_at', 'updated_at'];
}
