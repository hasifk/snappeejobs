<?php

namespace App\Models\Access\User\Traits\Attribute;

use Illuminate\Support\Facades\Hash;
use DB;

/**
 * Class EmployerAttribute
 * @package App\Models\Access\User\Traits\Attribute
 */
trait CompanyVisitorAttribute
{



    public function setUserIdAttribute($value)
    {
        $this->attributes['user_id'] = $value ?: null;
    }


}