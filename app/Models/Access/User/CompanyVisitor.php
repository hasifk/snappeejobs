<?php namespace App\Models\Access\User;

use Illuminate\Database\Eloquent\Model;

/**
 * Class UserProvider
 * @package App\Models\Access\User
 */
class CompanyVisitor extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'company_visitors';

    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];
}
