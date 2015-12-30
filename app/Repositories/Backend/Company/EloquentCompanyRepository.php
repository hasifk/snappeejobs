<?php

namespace app\Repositories\Backend\Company;


use App\Events\Backend\Company\CompanyCreated;
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
        $this->employerId = $this->user->user()->employer->id;
    }

    public function findOrThrowException() {

        $company = Company::where('employer_id', $this->employerId)->first();

        return $company;
    }

    public function save($request){

        $company = $this->findOrThrowException();

        if ( $company ) {

            $this->updateCompanyStub($request, $company);

            if ($company->save()) {

                $this->flushIndustries($request->get('industry_company'), $company);

                $this->flushSocialMedia($request->get('social_media'), $company);

                $this->flushVideos($request->get('video_url'), $company);

                Event::fire(new CompanyCreated($company, $this->employerId ));
                return $company;

            }

        } else {

            $company = $this->createCompanyStub($request);

            if ($company->save()) {

                $company->attachIndustries($request->get('industry_company'));

                $company->attachSocialMedia($request->get('social_media'));

                $company->attachVideos($request->get('video_url'));

                Event::fire(new CompanyCreated($company, $this->employerId ));
                return $company;
            }

        }

        throw new GeneralException('There was a problem creating this user. Please try again.');
    }

    private function flushIndustries($industries, $company) {
        $company->detachIndustries($company->industries);
        $company->attachIndustries($industries);
    }

    private function flushSocialMedia($socialmedia, $company) {
        $company->detachSocialMedia($company->socialmedia);
        $company->attachSocialMedia($socialmedia);
    }

    private function flushVideos($videos, $company) {
        $company->detachVideos($company->videos);
        $company->attachVideos($videos);
    }

    public function createCompanyStub($input){
        $company = new Company();
        $company->employer_id      = $this->employerId;
        $company->title            = $input['title'];
        $company->size             = $input['size'];
        $company->description      = $input['description'];
        $company->what_it_does     = $input['what_it_does'];
        $company->office_life      = $input['office_life'];
        $company->country_id       = $input['country_id'];
        $company->state_id         = $input['state_id'];
        return $company;
    }

    public function updateCompanyStub($input, $company){
        $company->employer_id      = $this->employerId;
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