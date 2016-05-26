<?php

namespace App\Models\Blogs;



use App\Models\Blogs\Traits\Attribute\BlogAttribute;
use Illuminate\Database\Eloquent\Model;
class Blog extends Model
{
    use BlogAttribute;

    protected $table = 'blogs';

    protected $guarded = ['id'];


}
