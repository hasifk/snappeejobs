<?php

namespace App\Models\Mail\Relationship;

use App\Models\Mail\Message;

trait MailRelationship
{
    public function messages(){
        return $this->hasOne(Message::class, 'id', 'thread_id');
    }

}