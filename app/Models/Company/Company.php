<?php

namespace App\Models\Company;

use App\Models\Company\Traits\Attribute\CompanyAttribute;
use App\Models\Company\Traits\Relationship\CompanyRelationship;
use App\Models\Company\Traits\CompanyProperties;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{

    use CompanyRelationship,
        CompanyProperties,
        CompanyAttribute;

    protected $table = 'companies';

    protected $guarded = ['id'];
}
