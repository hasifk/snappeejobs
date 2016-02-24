<?php

namespace app\Models\Company\NewCompanyTemp\Traits\Attribute;

trait NewCompanyTempAttribute
{

    public function getCreateCompanyButtonAttribute(){
        return '<a href="'.route('admin.company.create', $this->id).'" class="btn btn-xs btn-primary"><i class="fa fa-plus" data-toggle="tooltip" data-placement="top" title="Create"></i></a> ';
    }

    public function getActionButtonsAttribute() {
        return $this->getCreateCompanyButtonAttribute();
    }
}
