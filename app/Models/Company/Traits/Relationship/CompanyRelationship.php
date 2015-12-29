<?php

namespace App\Models\Company\Traits\Attribute\Relationship;


trait CompanyRelationship
{
    public function industries(){
        return $this->belongsToMany(
            'App\Models\Company\Industry\Industry', 'industry_employer', 'company_id', 'industry_id'
        );
    }
}