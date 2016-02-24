<?php

namespace App\Models\Company\NewCompanyTemp;

use App\Models\Company\NewCompanyTemp\Traits\Attribute\NewCompanyTempAttribute;
use App\Models\Company\NewCompanyTemp\Traits\Relationship\NewCompanyTempRelationship;
use Illuminate\Database\Eloquent\Model;

class NewCompanyTemp extends Model
{

    use NewCompanyTempAttribute, NewCompanyTempRelationship;

    protected $table = 'new_company_temps';

    protected $fillable = ['employer_id', 'completed'];
}
