<?php

namespace App\Models\Company\Traits\Relationship;


use App\Models\Country\Country;
use App\Models\State\State;

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

    public function people(){
        return $this->hasMany('App\Models\Company\People\People', 'company_id');
    }

    public function photos(){
        return $this->hasMany('App\Models\Company\Photo\Photo', 'company_id');
    }

    public function jobs(){
        return $this->hasMany('App\Models\Job\Job', 'company_id');
    }
   

    public function country(){
        return $this->belongsTo(Country::class);
    }

    public function state(){
        return $this->belongsTo(State::class);
    }
     
}
