<?php

namespace App\Models\Job\Traits;


use App\Models\Job\JobPrerequisites\JobPrerequisites;
use Carbon\Carbon;
use DB;

trait JobAttribute
{

    public function attachCategories($categories)
    {
        foreach ($categories as $category) {
            $this->attachCategory($category);
        }
    }

    public function attachSkills($skills)
    {
        foreach ($skills as $skill) {
            $this->attachSkill($skill);
        }
    }

    public function attachPrerequisites($prerequisites)
    {
        foreach ($prerequisites as $prerequisite) {
            $this->attachPrerequisite($prerequisite);
        }
    }

    public function detachCategories()
    {
        \DB::table('category_preferences_jobs')
            ->where('job_id', $this->id)
            ->delete();
    }

    public function detachSkills()
    {
        \DB::table('job_skills')
            ->where('job_id', $this->id)
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
        \DB::table('category_preferences_jobs')->insert([
            'job_id'                => $this->id,
            'job_category_id'       => $category
        ]);
    }

    public function attachSkill($skill)
    {
        \DB::table('job_skills')->insert([
            'job_id'                => $this->id,
            'skill_id'              => $skill,
            'created_at'            => Carbon::now(),
            'updated_at'            => Carbon::now(),
        ]);
    }

    /**
     * @param $prerequisite
     */
    public function attachPrerequisite($prerequisite){
        if ( ! $prerequisite ) {
            return;
        }

        \DB::table('job_prerequisites')->insert([
            'job_id'        => $this->id,
            'content'       => $prerequisite,
            'created_at'    => Carbon::now(),
            'updated_at'    => Carbon::now(),
        ]);

//        $prerequisite = new JobPrerequisites(['content' => $prerequisite]);
//        $this->prerequisites()->save($prerequisite);
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
                //$buttons .= '<a href="'.route('admin.employer.jobs.mark', [$this->id, 2]).'" class="btn btn-xs btn-danger"><i class="fa fa-times" data-toggle="tooltip" data-placement="top" title="Ban Job"></i></a> ';
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
            return '<a href="'.route('admin.employer.jobs.destroy', $this->id).'" data-method="delete" class="btn btn-xs btn-danger"><i class="fa fa-trash" data-toggle="tooltip" data-placement="top" title="' . trans('crud.delete_button') . '"></i></a>';
        return '';
    }

    public function getManageJobButtonAttribute(){
        if (access()->can('employer-jobs-view-jobapplications'))
            return '<a href="'.route('admin.employer.jobs.manage', $this->id).'" class="btn btn-xs btn-info"><i class="ion ion-ios-gear-outline" data-toggle="tooltip" data-placement="top" title="Manage Job Applications"></i></a>&nbsp;';
        return '';
    }

    public function getActionButtonsAttribute() {
        return $this->getManageJobButtonAttribute().
        $this->getEditButtonAttribute().
        $this->getStatusButtonAttribute().
        $this->getPublishedButtonAttribute().
        $this->getDeleteButtonAttribute();
    }

    public function getJobAppliedAttribute(){
        if (auth()->guest()) return false;

        return \DB::table('job_applications')
            ->where('job_id', $this->id)
            ->where('user_id', auth()->user()->id)
            ->count()
                ?
            true : false;
    }

}
