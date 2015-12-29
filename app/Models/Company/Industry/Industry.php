<?php

namespace App\Models\Company\Industry;

use Illuminate\Database\Eloquent\Model;

class Industry extends Model
{
    protected $table;
    protected $guarded = ['id'];
    public function __construct()
    {
        $this->table = 'industries';
    }
}
