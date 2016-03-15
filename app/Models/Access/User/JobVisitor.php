<?php namespace App\Models\Access\User;

use Illuminate\Database\Eloquent\Model;

/**
 * Class UserProvider
 * @package App\Models\Access\User
 */
class JobVisitor extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'job_visitors';

    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];
}
