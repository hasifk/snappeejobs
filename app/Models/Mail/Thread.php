<?php

namespace App\Models\Mail;

use App\Models\Mail\Relationship\MailRelationship;
use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{

    use MailRelationship;

    protected $table = 'threads';

    protected $guarded = ['id'];

    protected $dates = ['created_at', 'updated_at'];
}
