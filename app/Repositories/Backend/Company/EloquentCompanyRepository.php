<?php

namespace app\Repositories\Backend\Company;


use App\Exceptions\GeneralException;
use App\Models\Company\Company;
use App\Repositories\Backend\Role\RoleRepositoryContract;
use App\Repositories\Frontend\Auth\AuthenticationContract;
use Event;
use Illuminate\Contracts\Auth\Guard;

class EloquentCompanyRepository
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
    }

    public function findOrThrowException($id) {

        $company = Company::find($this->user->user()->employer->id);

        return $company;
    }

    public function create($request){
        $company = $this->createCompanyStub($request);

        if ($company->save()) {
            Event::fire(new CompanyCreated($company, $this->user->user()->employer->id ));
        }

        throw new GeneralException('There was a problem creating this user. Please try again.');
    }

    public function createCompanyStub($input){
        $company = new Company();
        $company->title            = $input['title'];
        $company->size             = $input['size'];
        $company->description      = $input['description'];
        $company->what_it_does     = $input['what_it_does'];
        $company->office_life      = $input['office_life'];
        $company->country_id       = $input['country_id'];
        $company->state_id         = $input['state_id'];
        return $company;
    }

}