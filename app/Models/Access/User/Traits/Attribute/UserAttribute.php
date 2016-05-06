<?php namespace App\Models\Access\User\Traits\Attribute;

use App\Models\JobSeeker\JobSeeker;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use DB;

/**
 * Class UserAttribute
 * @package App\Models\Access\User\Traits\Attribute
 */
trait UserAttribute {

    /**
     * Hash the users password
     *
     * @param $value
     */
    public function setPasswordAttribute($value)
    {
        if (Hash::needsRehash($value))
            $this->attributes['password'] = bcrypt($value);
        else
            $this->attributes['password'] = $value;
    }

    public function setDobAttribute($value){
        if ( is_null($value) ) :
            $this->attributes['dob'] = Carbon::now();

        else:
            $date=new \DateTime($value);
            $this->attributes['dob']=$date->format('Y-m-d');


        endif;
    }

    public function getDobAttribute($value){

        return Carbon::parse($value)->format('d/m/Y');

    }

    /**
     * @return string
     */
    public function getConfirmedLabelAttribute() {
        if ($this->confirmed == 1)
            return "<label class='label label-success'>Yes</label>";
        return "<label class='label label-danger'>No</label>";
    }

    /**
     * @return mixed
     */
    public function getAvatarImage($size) {
        if ( $this->avatar_filename ) {
            return 'https://s3-'. env('AWS_S3_REGION', 'eu-west-1') .'.amazonaws.com/'.
            env('AWS_S3_BUCKET', 'snappeejobs').'/'.
            $this->avatar_path.
            $this->avatar_filename.'.'.
            $this->avatar_extension;
        } else {
            return gravatar()->get($this->email, ['size' => $size]);
        }
    }

    /**
     * @return mixed
     */
    public function getPictureAttribute($height = null, $width = null) {
        if ( $this->avatar_filename ) {
            return 'https://s3-'. env('AWS_S3_REGION', 'eu-west-1') .'.amazonaws.com/'.
            env('AWS_S3_BUCKET', 'snappeejobs').'/'.
            $this->avatar_path.
            $this->avatar_filename. ( $height ? $height : '' ) . ($height && $width ? 'x' : '') . ( $width ? $width : '' ) . '.'.
            $this->avatar_extension;
        } else {
            return gravatar()->get($this->email, ['size' => $height]);
        }
    }

    /**
     * @return string
     */
    public function getEditButtonAttribute() {
        if (access()->can('edit-users'))
            return '<a href="'.route('admin.access.users.edit', $this->id).'" class="btn btn-xs btn-primary"><i class="fa fa-pencil" data-toggle="tooltip" data-placement="top" title="' . trans('crud.edit_button') . '"></i></a> ';
        return '';
    }

    /**
     * @return string
     */
    public function getChangePasswordButtonAttribute() {
        if (access()->can('change-user-password'))
            return '<a href="'.route('admin.access.user.change-password', $this->id).'" class="btn btn-xs btn-info"><i class="fa fa-refresh" data-toggle="tooltip" data-placement="top" title="' . trans('crud.change_password_button') . '"></i></a>';
        return '';
    }

    /**
     * @return string
     */
    public function getStatusButtonAttribute() {
        switch($this->status) {
            case 0:
                if (access()->can('reactivate-users'))
                    return '<a href="'.route('admin.access.user.mark', [$this->id, 1]).'" class="btn btn-xs btn-success"><i class="fa fa-play" data-toggle="tooltip" data-placement="top" title="' . trans('crud.activate_user_button') . '"></i></a> ';
                break;

            case 1:
                $buttons = '';

                if (access()->can('deactivate-users'))
                    $buttons .= '<a href="'.route('admin.access.user.mark', [$this->id, 0]).'" class="btn btn-xs btn-warning"><i class="fa fa-pause" data-toggle="tooltip" data-placement="top" title="' . trans('crud.deactivate_user_button') . '"></i></a> ';

                if (access()->can('ban-users'))
                    $buttons .= '<a href="'.route('admin.access.user.mark', [$this->id, 2]).'" class="btn btn-xs btn-danger"><i class="fa fa-times" data-toggle="tooltip" data-placement="top" title="' . trans('crud.ban_user_button') . '"></i></a> ';

                return $buttons;
                break;

            case 2:
                if (access()->can('reactivate-users'))
                    return '<a href="'.route('admin.access.user.mark', [$this->id, 1]).'" class="btn btn-xs btn-success"><i class="fa fa-play" data-toggle="tooltip" data-placement="top" title="' . trans('crud.activate_user_button') . '"></i></a> ';
                break;

            default:
                return '';
                break;
        }

        return '';
    }

    public function getConfirmedButtonAttribute() {
        if (! $this->confirmed)
            if (access()->can('resend-user-confirmation-email'))
                return '<a href="'.route('admin.account.confirm.resend', $this->id).'" class="btn btn-xs btn-success"><i class="fa fa-refresh" data-toggle="tooltip" data-placement="top" title="Resend Confirmation E-mail"></i></a> ';
        return '';
    }

    /**
     * @return string
     */
    public function getDeleteButtonAttribute() {
        if (access()->can('delete-users'))
            return '<a href="'.route('admin.access.users.destroy', $this->id).'" data-method="delete" class="btn btn-xs btn-danger"><i class="fa fa-trash" data-toggle="tooltip" data-placement="top" title="' . trans('crud.delete_button') . '"></i></a>';
        return '';
    }

    /**
     * @return string
     */
    public function getActionButtonsAttribute() {
        return $this->getEditButtonAttribute().
        $this->getChangePasswordButtonAttribute().' '.
        $this->getStatusButtonAttribute().
        $this->getConfirmedButtonAttribute().
        $this->getDeleteButtonAttribute();
    }

    public function getCountryNameAttribute() {
        return DB::table('countries')->where('id', $this->country_id)->value('name');
    }

    public function getStateNameAttribute() {
        return DB::table('states')->where('id', $this->state_id)->value('name');
    }

    public function getJobSeekerDetailsAttribute(){

        if (! access()->hasRole('User') ) {
            return;
        }

        return DB::table('job_seeker_details')->where('user_id', $this->id)->first();
    }

    public function getJobSeekerSkillsAttribute(){
        if (! access()->hasRole('User') ) {
            return;
        }

        return DB::table('skills_job_seeker')->where('user_id', $this->id)->get();
    }

    public function getJobSeekerCategoryPreferencesAttribute(){
        if (! access()->hasRole('User') ) {
            return;
        }

        return DB::table('category_preferences_job_seeker')->where('user_id', $this->id)->get();
    }

    public function getAgeAttribute(){
        return Carbon::parse($this->dob)->diffInYears();
    }



    public function getResumeAttribute(){
        $jobSeeker = JobSeeker::where('user_id', $this->id)->first();
        return $this->getFileUrl($jobSeeker->resume_path.$jobSeeker->resume_filename.'.'.$jobSeeker->resume_extension);
    }

    private function getFileUrl($key) {
        $s3 = \Storage::disk('s3');
        $client = $s3->getDriver()->getAdapter()->getClient();
        $bucket = config('filesystems.disks.s3.bucket');

        $command = $client->getCommand('GetObject', [
            'Bucket' => $bucket,
            'Key' => $key
        ]);

        $request = $client->createPresignedRequest($command, '+10 minutes');

        return (string) $request->getUri();
    }
}
