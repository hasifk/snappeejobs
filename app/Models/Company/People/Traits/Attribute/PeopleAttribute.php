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
}