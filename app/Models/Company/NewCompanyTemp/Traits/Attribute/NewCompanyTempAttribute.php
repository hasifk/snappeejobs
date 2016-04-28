<?php

namespace app\Models\Company\NewCompanyTemp\Traits\Attribute;

trait NewCompanyTempAttribute
{

    public function getCreateCompanyButtonAttribute(){
        return '<a href="'.route('admin.company.create', $this->employer_id).'" class="btn btn-xs btn-primary"><i class="fa fa-plus" data-toggle="tooltip" data-placement="top" title="Create"></i></a> ';
    }

    public function getActionButtonsAttribute() {
        return $this->getCreateCompanyButtonAttribute();
    }

    public function getEmployerNameAttribute(){
        if ( is_null($this->employer_id) ) {
            return null;
        }
        return \DB::table('users')->where('employer_id', $this->employer_id)->value('name');
    }
}
