<?php

namespace App\Models\JobSeeker;

use Illuminate\Database\Eloquent\Model;

class JobSeekerImage extends Model
{
    protected $table = 'job_seeker_images';

    protected $guarded = ['id'];

    public function getImageAttribute(){
        if ( $this->filename ) {
            return 'https://s3-'. env('AWS_S3_REGION', 'eu-west-1') .'.amazonaws.com/'.
            env('AWS_S3_BUCKET', 'snappeejobs').'/'.
            $this->path.
            $this->filename.'.'.
            $this->extension;
        } else {
            return null;
        }
    }
}
