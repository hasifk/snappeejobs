<?php namespace App\Models\Access\User\Traits\Relationship;

use App\EmployerAddonHistory;
use App\EmployerAddonPackHistory;
use App\Models\Access\User\EmployerPlan;
use App\Models\Access\User\UserProvider;

/**
 * Class UserRelationship
 * @package App\Models\Access\User\Traits\Relationship
 */
trait UserRelationship {

    /**
     * Many-to-Many relations with Role.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany(config('access.role'), config('access.assigned_roles_table'), 'user_id', 'role_id');
    }

    /**
     * Many-to-Many relations with Permission.
     * ONLY GETS PERMISSIONS ARE NOT ASSOCIATED WITH A ROLE
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function permissions()
    {
        return $this->belongsToMany(config('access.permission'), config('access.permission_user_table'), 'user_id', 'permission_id');
    }

    /**
     * @return mixed
     */
    public function providers() {
        return $this->hasMany(UserProvider::class, 'user_id');
    }

    public function employerPlan(){
        return $this->hasOne(EmployerPlan::class, 'employer_id');
    }

    public function employerAddonPackHistory(){
        return $this->hasMany(EmployerAddonPackHistory::class, 'employer_id');
    }

    public function employerAddonHistory(){
        return $this->hasMany(EmployerAddonHistory::class, 'employer_id');
    }
}
