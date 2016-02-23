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

    public function getShowButtonAttribute(){
        if (access()->can('company-management'))
            return '<a href="'.route('admin.company.show', $this->id).'" class="btn btn-xs btn-primary"><i class="fa fa-eye" data-toggle="tooltip" data-placement="top" title="View"></i></a> ';
        return '';
    }

    public function getEditButtonAttribute(){
        if (access()->can('company-management'))
            return '<a href="'.route('admin.company.edit', $this->id).'" class="btn btn-xs btn-primary"><i class="fa fa-pencil" data-toggle="tooltip" data-placement="top" title="Edit"></i></a> ';
        return '';
    }

    public function getActionButtonsAttribute() {
        return $this->getShowButtonAttribute(). " " . $this->getEditButtonAttribute();
    }

}
