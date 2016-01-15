<?php

namespace App\Http\Controllers\Frontend\Company;

use App\Http\Controllers\Controller;
use App\Models\Company\People\People;
use App\Repositories\Frontend\Company\EloquentCompanyRepository;
use DB;

class CompaniesController extends Controller
{
    /**
     * @var EloquentCompanyRepository
     */

    private $companyRepository;

    /**
     * JobsController constructor.
     * @param EloquentCompanyRepository $companyRepository
     */

    public function __construct(EloquentCompanyRepository $companyRepository)
    {
        $this->companyRepository = $companyRepository;
    }

    public function index()
    {

        $companies = $this->companyRepository->getCompaniesPaginated(config('companies.default_per_page'));

        return view('frontend.companies.index',['companies'=>$companies]);

    }

    public function company($slug)
    {

        $company = $this->companyRepository->getCompanyBySlug($slug);

        return view('frontend.companies.company',['company'	=>	$company]);

    }

    public function people($slug,$id)
    {

        $people = People::find($id);

        $company = $this->companyRepository->getCompanyBySlug($slug);

        return view('frontend.companies.people',[
            'people' 	=> $people,
            'company' 	=> $company,
        ]);

    }
}