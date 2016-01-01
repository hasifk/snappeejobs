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

    public function getLogoImageAttribute() {
        return 'https://s3-'. env('AWS_S3_REGION') .'.amazonaws.com/'.
        env('AWS_S3_BUCKET').'/'.
        "companies/" . $this->id."/logo/".
        $this->logo;
    }

}