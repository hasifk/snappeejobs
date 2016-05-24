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
            return '<a href="'.route('backend.admin.cms.destroy', $this->id).'"  class="cms_delete btn btn-xs btn-danger"><i class="fa fa-trash" data-toggle="tooltip" data-placement="top" title="' . trans('crud.delete_button') . '"></i></a>';
        return '';
    }

     public function getShowButtonAttribute(){
        if (access()->can('show-cms'))
            return '<a href="'.route('backend.admin.cmsshow', $this->id).'" class="btn btn-xs btn-success"><i class="fa fa-arrow-circle-right" data-toggle="tooltip" data-placement="top" title="View More"></i></a> ';
        return '';
    }

     public function getPublishedTextAttribute(){
        if ( $this->published ) {
            return '<span class="btn btn-xs btn-success">Published</span>';
        } else {
            return '<span class="btn btn-xs btn-warning">Not Published</span>';
        }
        return '';
    }
    
     public function getPublishedButtonAttribute(){
        if ( $this->published ) {
            return '<a href="'.route('backend.admin.cms.hide', [$this->id]).'" class="btn btn-xs btn-info"><i class="fa fa-eye-slash" data-toggle="tooltip" data-placement="top" title="Hide"></i></a> ';
        } else {
            return '<a href="'.route('backend.admin.cms.publish', [$this->id]).'" class="btn btn-xs btn-info"><i class="fa fa-eye" data-toggle="tooltip" data-placement="top" title="Publish"></i></a> ';
        }
    }

    public function getImageAttribute($width,$height){
        if ($this->cms_filename && $this->cms_extension && $this->cms_path) {
            return '<img src="'.
            'https://s3-'. env('AWS_S3_REGION', 'eu-west-1') .'.amazonaws.com/'.
            env('AWS_S3_BUCKET', 'snappeejobs').'/'.
            $this->cms_path.$this->cms_filename.$width.'x'.$height.'.'.$this->cms_extension .
            '" alt="image" style="height: '.$height.'px; width:'.$width.'px;">';
        } else {
            return '';
        }
    }

    /**
     * @return string
     */
    
    public function getActionButtonsAttribute() {
        
        return $this->getShowButtonAttribute().
        $this->getPublishedButtonAttribute().
        $this->getEditButtonAttribute().
        $this->getDeleteButtonAttribute();
    }
}
