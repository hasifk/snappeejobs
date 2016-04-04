<?php

namespace App\Models\Company;

use Illuminate\Database\Eloquent\Model;

class CompanyFollowers extends Model
{



    protected $table = 'follow_companies';

    protected $guarded = ['id'];
}
