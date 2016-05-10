<?php namespace App\Models\Access\Role;

use Illuminate\Database\Eloquent\Model;
use App\Models\Access\Role\Traits\RoleAccess;
use App\Models\Access\Role\Traits\Attribute\RoleAttribute;
use App\Models\Access\Role\Traits\Relationship\RoleRelationship;

/**
 * Class Role
 * @package App\Models\Access\Role
 */
class AssignedRoles extends Model {


    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table;

    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     *
     */
    public function __construct()
    {
        $this->table = config('access.assigned_roles_table');
    }
}