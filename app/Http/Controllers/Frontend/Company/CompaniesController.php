<?php

namespace App\Http\Controllers\Frontend\Company;

use App\Http\Controllers\Controller;
use App\Models\Company\People\People;
use App\Repositories\Frontend\Company\EloquentCompanyRepository;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Session;

//require_once 'vendor/autoload.php';
/*use GeoIp2\Database\Reader;*/

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

    public function company($slug,Request $request)
    {

        $company = $this->companyRepository->getCompanyBySlug($slug);
        if (!Session::get('company_visitor_info_stored')):

            $current_ip = $request->ip();
            $visits = $this->companyRepository->storeCompanyvisits($slug, $current_ip);


            if(!empty($visits)):
                Session::put('company_visitor_info_stored', true);
                Session::save();
            else:
                return redirect(route('companies.search'));
            endif;

        endif;

             return view('frontend.companies.company',['company'	=>	$company]);




    }

    public function next($companyId){
        $nextCompanyUrlSlug = \DB::table('companies')->where('id', '<>', $companyId)->orderByRaw('RAND()')->value('url_slug');
        return redirect(route('companies.view', $nextCompanyUrlSlug));
    }

    public function likeCompany(Request $request)
    {

        $companyId = $request->get('companyId');

        if (! \DB::table('like_companies')->where('company_id', $companyId)->where('user_id', auth()->user()->id)->count() ) {
            \DB::table('like_companies')->insert([
                'company_id'    => $companyId,
                'user_id'       => auth()->user()->id,
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()
            ]);
            \DB::table('companies')
                ->where('id',$companyId)
                ->increment('likes');
        }

        $likes = \DB::table('companies')
            ->where('id',$companyId)
            ->value('likes');

        return json_encode(['status'=>1,'likes'=>$likes]);

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
