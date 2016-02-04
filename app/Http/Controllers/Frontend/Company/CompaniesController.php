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

        $industries = \DB::table('industries')->select(['id', 'name'])->get();

        $locations = \DB::table('states')
            ->join('countries','states.country_id','=','countries.id')
            ->select([
                'states.id',
                'states.name As state',
                'countries.iso_code_2 As country_code'
            ])->get();

        $companies_data = $this->companyRepository->getCompaniesPaginated($request, config('companies.default_per_page'));

        return view('frontend.companies.index',[
            'industries' =>  $industries,
            'locations'  =>  $locations,
            'companies_data'  =>  $companies_data
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