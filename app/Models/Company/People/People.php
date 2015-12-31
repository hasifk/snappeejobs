<?php

namespace App\Models\Company\People;

use App\Models\Company\People\Traits\Attribute\PeopleAttribute;
use Illuminate\Database\Eloquent\Model;

class People extends Model
{

    use PeopleAttribute;

    protected $table = 'people_company';

    protected $guarded = ['id'];

    protected $fillable = [
        'company_id',
        'name',
        'designation',
        'about_me',
        'path',
        'filename',
        'extension',
        'testimonial'
    ];
}
