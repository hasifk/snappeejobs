<?php

namespace App\Models\Access\User\Traits\Attribute;



/**
 * Class EmployerAttribute
 * @package App\Models\Access\User\Traits\Attribute
 */
trait JobVisitorAttribute
{



    public function setUserIdAttribute($value)
    {
        $this->attributes['user_id'] = $value ?: null;
    }




}