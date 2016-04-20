<?php

namespace App\Models\Job\JobApplication\Traits\Attribute;

use DB;

trait JobApplicationAttribute
{

    public function getViewtButtonAttribute(){
        return '<a href="'.route('admin.employer.jobs.application', $this->id).'" class="btn btn-xs btn-primary"><i class="fa fa-eye" data-toggle="tooltip" data-placement="top" title="View"></i></a> ';
    }

    public function getAcceptButtonAttribute(){
        return '<a href="'.route('admin.employer.jobs.application.accept', $this->id).'" class="btn btn-xs btn-primary"><i class="fa fa-check-square-o" data-toggle="tooltip" data-placement="top" title="Accept"></i></a> ';
    }

    public function getDeclinePasswordButtonAttribute(){
        return '<a href="'.route('admin.employer.jobs.application.decline', $this->id).'" class="btn btn-xs btn-danger"><i class="fa fa-ban" data-toggle="tooltip" data-placement="top" title="Decline"></i></a> ';
    }

    public function getManageButtonAttribute(){
        return '<a href="'.route('admin.employer.jobs.manage', $this->job_id).'" class="btn btn-xs btn-info"><i class="ion ion-ios-gear-outline" data-toggle="tooltip" data-placement="top" title="Manage Job Applications"></i></a>&nbsp; ';
    }



    public function getActionButtonsAttribute() {
        return $this->getViewtButtonAttribute() . $this->getManageButtonAttribute();
    }

    public function getStatusAttribute(){
        if ( is_null($this->accepted_at) && $this->declined_at ) {
            return 'Rejected';
        } else if ( is_null($this->declined_at) && $this->accepted_at ) {
            return 'Accepted';
        } else {
            return 'Not decided';
        }
    }
}
