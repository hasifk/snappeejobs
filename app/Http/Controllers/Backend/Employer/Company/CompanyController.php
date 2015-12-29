<?php

namespace App\Http\Controllers\Backend\Employer\Company;

use App\Models\Company\Company;
use App\Repositories\Backend\Company\EloquentCompanyRepository;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class CompanyController extends Controller
{
    /**
     * @var EloquentCompanyRepository
     */
    private $company;

    /**
     * CompanyController constructor.
     * @param EloquentCompanyRepository $company
     */
    public function __construct(EloquentCompanyRepository $company)
    {
        $this->company = $company;
    }

    public function showProfile(){
        $company = $this->company->findOrThrowException(auth()->user()->employer->id);
        $view = [ 'company' => $company ];
        return view('backend.employer.company.showprofile', $view);
    }

    public function editProfile(Requests\Backend\Employer\Company\CompanyProfileViewRequest $request){
        $company = $this->company->findOrThrowException(auth()->user()->employer->id);
        $industries = \DB::table('industries')->select(['id', 'name'])->get();
        $countries = \DB::table('countries')->select(['id', 'name'])->get();
        if ( auth()->user()->country_id ) {
            $states = \DB::table('states')->where('country_id', auth()->user()->country_id)->select(['id', 'name'])->get();
        } else {
            $states = \DB::table('states')->where('country_id', 222)->select(['id', 'name'])->get();
        }
        $view = [
                    'company'       => $company,
                    'countries'     => $countries,
                    'states'        => $states,
                    'industries'    => $industries
                ];
        return view('backend.employer.company.editprofile', $view);
    }

    public function updateProfile(Requests\Backend\Employer\Company\CompanyProfileEditRequest $request){

        $this->company->findOrThrowException(1);

    }


}
