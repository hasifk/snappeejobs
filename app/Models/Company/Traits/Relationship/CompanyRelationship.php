<?php

namespace App\Models\Company\Traits\Relationship;


trait CompanyRelationship
{
    public function industries(){
        return $this->belongsToMany(
            'App\Models\Company\Industry\Industry', 'industry_company', 'company_id', 'industry_id'
        );
    }

    public function socialmedia(){
        return $this->hasMany('App\Models\Company\SocialMediaCompany\SocialMediaCompany', 'company_id');
    }

    public function videos(){
        return $this->hasMany('App\Models\Company\Video\Video', 'company_id');
    }
}