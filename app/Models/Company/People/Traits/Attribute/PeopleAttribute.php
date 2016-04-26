<?php

namespace App\Models\Company\People\Traits\Attribute;

use Illuminate\Support\Facades\Hash;
use DB;

/**
 * Class EmployerAttribute
 * @package App\Models\Access\User\Traits\Attribute
 */
trait PeopleAttribute
{
    public function getImageAttribute() {
        return 'https://s3-'. env('AWS_S3_REGION') .'.amazonaws.com/'.
        env('AWS_S3_BUCKET').'/'.
        $this->path.
        $this->filename.'.'.
        $this->extension;
    }

    public function getPictureAttribute($height = null, $width = null) {
        if ( $this->filename ) {
            return 'https://s3-'. env('AWS_S3_REGION', 'eu-west-1') .'.amazonaws.com/'.
            env('AWS_S3_BUCKET', 'snappeejobs').'/'.
            $this->path.
            $this->filename. ( $height ? $height : '' ) . ($height && $width ? 'x' : '') . ( $width ? $width : '' ) . '.'.
            $this->extension;
        } else {
            return '';
        }
    }
}