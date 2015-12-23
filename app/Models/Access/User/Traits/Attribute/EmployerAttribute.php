<?php

namespace App\Models\Access\User\Traits\Attribute;

use Illuminate\Support\Facades\Hash;
use DB;

/**
 * Class EmployerAttribute
 * @package App\Models\Access\User\Traits\Attribute
 */
trait EmployerAttribute
{
    public function getEmployerEditButtonAttribute() {
        if (access()->can('edit-employer-staff'))
            return '<a href="'.route('admin.employer.staffs.edit', $this->id).'" class="btn btn-xs btn-primary"><i class="fa fa-pencil" data-toggle="tooltip" data-placement="top" title="Edit"></i></a> ';
        return '';
    }
    public function getEmployerChangePasswordButtonAttribute() {
        if (access()->can('change-employer-staff-password'))
            return '<a href="'.route('admin.employer.staffs.change-password', $this->id).'" class="btn btn-xs btn-primary"><i class="fa fa-refresh" data-toggle="tooltip" data-placement="top" title="Change Password"></i></a> ';
        return '';
    }
    public function getEmployerStatusButtonAttribute() {
        switch($this->status) {
            case 0:
                if (access()->can('reactivate-employer-staff'))
                    return '<a href="'.route('admin.employer.staffs.mark', [$this->id, 1]).'" class="btn btn-xs btn-success"><i class="fa fa-play" data-toggle="tooltip" data-placement="top" title="Activate User"></i></a> ';
                break;

            case 1:
                $buttons = '';

                if (access()->can('deactivate-employer-staff'))
                    $buttons .= '<a href="'.route('admin.employer.staffs.mark', [$this->id, 0]).'" class="btn btn-xs btn-warning"><i class="fa fa-pause" data-toggle="tooltip" data-placement="top" title="Deactivate User"></i></a> ';

                if (access()->can('ban-employer-staff'))
                    $buttons .= '<a href="'.route('admin.employer.staffs.mark', [$this->id, 2]).'" class="btn btn-xs btn-danger"><i class="fa fa-times" data-toggle="tooltip" data-placement="top" title="Ban User"></i></a> ';

                return $buttons;
                break;

            case 2:
                if (access()->can('reactivate-employer-staff'))
                    return '<a href="'.route('admin.employer.staffs.mark', [$this->id, 1]).'" class="btn btn-xs btn-success"><i class="fa fa-play" data-toggle="tooltip" data-placement="top" title="Activate User"></i></a> ';
                break;

            default:
                return '';
                break;
        }

        return '';
    }
    public function getEmployerConfirmedButtonAttribute() {
        if (! $this->confirmed)
            if (access()->can('employer-resend-confirmation-email'))
                return '<a href="'.route('admin.employer.confirm.resend', $this->id).'" class="btn btn-xs btn-success"><i class="fa fa-refresh" data-toggle="tooltip" data-placement="top" title="Resend Confirmation E-mail"></i></a> ';
        return '';
    }
    public function getEmployerDeleteButtonAttribute() {
        if (access()->can('delete-employer-staff'))
            return '<a href="'.route('admin.employer.staffs.destroy', $this->id).'" data-method="delete" class="btn btn-xs btn-danger"><i class="fa fa-trash" data-toggle="tooltip" data-placement="top" title="' . trans('crud.delete_button') . '"></i></a>';
        return '';
    }

    public function getEmployerActionButtonsAttribute() {
        return $this->getEmployerEditButtonAttribute().
        $this->getEmployerChangePasswordButtonAttribute().' '.
        $this->getEmployerStatusButtonAttribute().
        $this->getEmployerConfirmedButtonAttribute().
        $this->getEmployerDeleteButtonAttribute();
    }
}