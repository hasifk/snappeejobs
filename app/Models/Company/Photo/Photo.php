<?php

namespace App\Models\Company\Photo;

use App\Models\Company\Photo\Traits\Attribute\PhotoAttribute;
use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{

    use PhotoAttribute;

    protected $table = 'photo_company';

    protected $guarded = ['id'];

    protected $fillable = [
        'company_id',
        'path',
        'filename',
        'extension'
    ];
}
