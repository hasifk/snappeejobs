<?php

namespace App\Http\Controllers\Frontend\Company;

use App\Http\Controllers\Controller;
use App\Models\Company\People\People;
use App\Repositories\Frontend\Company\EloquentCompanyRepository;
use DB;
use Illuminate\Http\Request;

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

    public function index(Request $request)
    {

        $companies = \DB::table('companies')->select(['id', 'title'])->get();
        $industries = \DB::table('industries')->select(['id', 'name'])->get();
        $countries = \DB::table('countries')->select(['id', 'name'])->get();
        if ( request('country_id') ) {
            $states = \DB::table('states')
                ->where('country_id', request('country_id'))
                ->select(['id', 'name'])
                ->get();
        } else {
            $states = \DB::table('states')
                ->where('country_id', 222)
                ->select(['id', 'name'])
                ->get();
        }

        $companies_data = $this->companyRepository->getCompaniesPaginated($request, config('companies.default_per_page'));

        return view('frontend.companies.index',[
            'countries'         => $countries,
            'states'            => $states,
            'industries'        =>  $industries,
            'companies'         =>  $companies,
            'companies_data'    =>  $companies_data
        ]);

    }

    public function company($slug)
    {

        $company = $this->companyRepository->getCompanyBySlug($slug);

        return view('frontend.companies.company',['company'	=>	$company]);

    }

    public function likeCompany(Request $request)
    {

        $companyId = $request->get('companyId');

        $likes = DB::table('companies')
            ->where('id',$companyId)
            ->value('likes');

        $res = DB::table('companies')
            ->where('id',$companyId)
            ->increment('likes');

        return json_encode(['status'=>$res,'likes'=>$likes]);

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
