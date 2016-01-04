<?php

namespace App\Repositories\Backend\Mail;


use App\Events\Backend\Company\CompanyCreated;
use App\Exceptions\GeneralException;
use App\Models\Company\Company;
use App\Repositories\Backend\Role\RoleRepositoryContract;
use App\Repositories\Frontend\Auth\AuthenticationContract;
use Event;
use Illuminate\Contracts\Auth\Guard;

class EloquentMailRepository
{
    /**
     * @var RoleRepositoryContract
     */
    private $role;
    /**
     * @var AuthenticationContract
     */
    private $auth;
    /**
     * @var Guard
     */
    private $user;
    private $employerId;

    /**
     * EloquentCompanyRepository constructor.
     * @param RoleRepositoryContract $role
     * @param AuthenticationContract $auth
     * @param Guard $user
     */
    public function __construct(RoleRepositoryContract $role, AuthenticationContract $auth, Guard $user)
    {

        $this->role = $role;
        $this->auth = $auth;
        $this->user = $user;
        dd($this->user->user()->id);
        $this->employerId = $this->user->user() ? $this->user->user()->employer->employer_id : null;
    }

    public function getEmployers(){
        return \DB::table('staff_employer')->where('employer_id', $this->employerId)->get();
    }

}