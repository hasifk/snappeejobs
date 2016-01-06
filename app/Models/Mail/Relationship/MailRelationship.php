<?php

namespace App\Models\Mail\Relationship;

use App\Models\Mail\Message\Message;

trait MailRelationship
{
    public function messages(){
        return $this->hasMany(Message::class);
    }

}