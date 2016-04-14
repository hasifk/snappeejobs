<?php

namespace App\Models\Project\Project\Traits\Attribute;

use DB;

trait ProjectAttribute
{

    public function getViewtButtonAttribute(){
        return '<a href="'.route('admin.projects.show', $this->id).'" class="btn btn-xs btn-info"><i class="fa fa-eye" data-toggle="tooltip" data-placement="top" title="View"></i></a> ';
    }

    public function getEditButtonAttribute(){
        return '<a href="'.route('admin.projects.edit', $this->id).'" class="btn btn-xs btn-info"><i class="fa fa-pencil" data-toggle="tooltip" data-placement="top" title="Edit"></i></a> ';
    }

    public function getTasksAssignButtonAttribute(){
        return '<a href="'.route('admin.projects.assign-tasks', $this->id).'" class="btn btn-xs btn-info"><i class="fa fa-tasks" data-toggle="tooltip" data-placement="top" title="Assign Tasks"></i></a> ';
    }

    public function getDeleteButtonAttribute(){
        return '<a href="'.route('admin.projects.destroy', $this->id).'" data-method="delete" class="btn btn-xs btn-danger"><i class="fa fa-trash" data-toggle="tooltip" data-placement="top" title="Delete"></i></a> ';
    }

    public function getActionButtonsAttribute() {
        return $this->getViewtButtonAttribute(). $this->getEditButtonAttribute()
        . $this->getTasksAssignButtonAttribute() . $this->getDeleteButtonAttribute();
    }

}
