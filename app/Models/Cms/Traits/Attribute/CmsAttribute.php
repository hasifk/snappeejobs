<?php namespace App\Models\Cms\Traits\Attribute;

use App\Models\Cms\Cms;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use DB;

/**
 * Class UserAttribute
 * @package App\Models\Access\User\Traits\Attribute
 */
trait CmsAttribute {

    /**
     * @return string
     */
    
    public function getEditButtonAttribute() {
        if (access()->can('edit-cms'))
            return '<a href="'.route('backend.admin.cms.edit', $this->id).'" class="btn btn-xs btn-primary"><i class="fa fa-pencil" data-toggle="tooltip" data-placement="top" title="' . trans('crud.edit_button') . '"></i></a> ';
        return '';
    }
    
    /**
     * @return string
     */
    public function getDeleteButtonAttribute() {
        if (access()->can('delete-cms'))
            return '<a href="'.route('backend.admin.cms.destroy', $this->id).'"  class="btn btn-xs btn-danger"><i class="fa fa-trash" data-toggle="tooltip" data-placement="top" title="' . trans('crud.delete_button') . '"></i></a>';
        return '';
    }

     public function getShowButtonAttribute(){
        if (access()->can('show-cms'))
            return '<a href="'.route('backend.admin.cmsshow', $this->id).'" class="btn btn-xs btn-primary"><i class="fa fa-eye" data-toggle="tooltip" data-placement="top" title="View"></i></a> ';
        return '';
    }

    /**
     * @return string
     */
    
    public function getActionButtonsAttribute() {
        return $this->getShowButtonAttribute().
        $this->getEditButtonAttribute().
        $this->getDeleteButtonAttribute();
    }
}
