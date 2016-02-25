<?php

namespace App\Models\Company\NewCompanyTemp\Traits\Relationship;

use App\Models\Access\User\User;

trait NewCompanyTempRelationship
{
    public function employer(){
        return $this->belongsTo(User::class, 'employer_id');
    }
}
