<?php

namespace App\Models\Company\Traits\Attribute;


use DB;

trait CompanyAttribute
{

    public function getCountryNameAttribute() {
        return DB::table('countries')->where('id', $this->country_id)->value('name');
    }

    public function getStateNameAttribute() {
        return DB::table('states')->where('id', $this->state_id)->value('name');
    }

}