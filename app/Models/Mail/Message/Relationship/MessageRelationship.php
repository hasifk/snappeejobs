<?php

namespace App\Models\Mail\Message\Relationship;

trait MessageRelationship
{
    public function sender(){
        return $this->belongsTo('App\Models\Access\User\User','sender_id');
    }

    public function thread(){
        return $this->belongsTo('App\Models\Mail\Thread','thread_id');
    }

}