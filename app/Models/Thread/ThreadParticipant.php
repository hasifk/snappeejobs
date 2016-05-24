<?php

namespace App\Models\Thread;

use App\Models\Mail\Relationship\MailRelationship;
use Illuminate\Database\Eloquent\Model;

class ThreadParticipant extends Model
{



    protected $table = 'thread_participants';

    protected $guarded = ['id'];

    protected $dates = ['created_at', 'updated_at'];
}
