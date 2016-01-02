<?php

namespace App\Models\Job\Traits;


use App\Models\Job\JobPrerequisites\JobPrerequisites;
use DB;

trait JobAttribute
{

    public function attachCategories($categories)
    {
        foreach ($categories as $category) {
            $this->attachCategory($category);
        }
    }

    public function attachPrerequisites($prerequisites)
    {
        foreach ($prerequisites as $prerequisite) {
            $this->attachPrerequisite($prerequisite);
        }
    }

    public function detachCategories($categories)
    {
        \DB::table('category_preferences_jobs')
            ->where('job_id', $this->id)
            ->whereIn('job_category_id', array_pluck($this->categories()->get()->toArray(), 'id'))
            ->delete();
    }

    public function detachPrerequisites()
    {
        \DB::table('job_prerequisites')
            ->where('job_id', $this->id)
            ->delete();
    }

    public function attachCategory($category)
    {
        if (is_object($category))
            $category = $category->getKey();

        if (is_array($category))
            $category = $category['id'];

        $this->categories()->attach($category);
    }

    /**
     * @param $prerequisite
     */
    public function attachPrerequisite($prerequisite){
        $this->prerequisites()->save(new JobPrerequisites(['text' => $prerequisite]));
    }

    public function detachCategory($category)
    {
        if( is_object($category))
            $category = $category->getKey();

        if( is_array($category))
            $category = $category['id'];

        $this->categories()->detach($category);
    }

    public function getCountryNameAttribute() {
        return DB::table('countries')->where('id', $this->country_id)->value('name');
    }

    public function getStateNameAttribute() {
        return DB::table('states')->where('id', $this->state_id)->value('name');
    }

    public function getEditButtonAttribute() {
        if (access()->can('employer-jobs-edit'))
            return '<a href="'.route('admin.employer.jobs.edit', $this->id).'" class="btn btn-xs btn-primary"><i class="fa fa-pencil" data-toggle="tooltip" data-placement="top" title="Edit"></i></a> ';
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

    public function getStatusTextAttribute(){
        switch($this->status) {
            case 0:
                return '<a class="btn btn-xs btn-warning">Disabled</a>';
                break;

            case 1:
                return '<a class="btn btn-xs btn-success">Enabled</a>';
                break;

            case 2:
                return '<a class="btn btn-xs btn-danger">Banned</a>';
                break;

            default:
                return '';
                break;
        }

        return '';
    }

    public function getStatusButtonAttribute() {

        if (! access()->can('employer-jobs-change-status')) {
            return '';
        }

        switch($this->status) {
            case 0:
                    return '<a href="'.route('admin.employer.jobs.mark', [$this->id, 1]).'" class="btn btn-xs btn-success"><i class="fa fa-play" data-toggle="tooltip" data-placement="top" title="Activate Job"></i></a> ';
                break;

            case 1:
                $buttons = '';
                $buttons .= '<a href="'.route('admin.employer.jobs.mark', [$this->id, 0]).'" class="btn btn-xs btn-warning"><i class="fa fa-pause" data-toggle="tooltip" data-placement="top" title="Deactivate Job"></i></a> ';
                $buttons .= '<a href="'.route('admin.employer.jobs.mark', [$this->id, 2]).'" class="btn btn-xs btn-danger"><i class="fa fa-times" data-toggle="tooltip" data-placement="top" title="Ban Job"></i></a> ';
                return $buttons;
                break;

            case 2:
                return '<a href="'.route('admin.employer.jobs.mark', [$this->id, 1]).'" class="btn btn-xs btn-success"><i class="fa fa-play" data-toggle="tooltip" data-placement="top" title="Activate Job"></i></a> ';
                break;

            default:
                return '';
                break;
        }

        return '';
    }

    public function getPublishedButtonAttribute(){
        if ( $this->published ) {
            return '<a href="'.route('admin.employer.jobs.hide', [$this->id]).'" class="btn btn-xs btn-info"><i class="fa fa-eye-slash" data-toggle="tooltip" data-placement="top" title="Hide"></i></a> ';
        } else {
            return '<a href="'.route('admin.employer.jobs.publish', [$this->id]).'" class="btn btn-xs btn-info"><i class="fa fa-eye" data-toggle="tooltip" data-placement="top" title="Publish"></i></a> ';
        }
    }

    public function getDeleteButtonAttribute() {
        if (access()->can('employer-jobs-delete'))
            return '<a href="'.route('admin.employer.staffs.destroy', $this->id).'" data-method="delete" class="btn btn-xs btn-danger"><i class="fa fa-trash" data-toggle="tooltip" data-placement="top" title="' . trans('crud.delete_button') . '"></i></a>';
        return '';
    }

    public function getActionButtonsAttribute() {
        return $this->getEditButtonAttribute().
        $this->getStatusButtonAttribute().
        $this->getPublishedButtonAttribute().
        $this->getDeleteButtonAttribute();
    }

}