<?php

namespace App\Http\Controllers\Frontend\Company;

use App\Http\Controllers\Controller;
use App\Models\Company\Company;
use App\Models\Company\CompanyFollowers;
use App\Models\Company\People\People;
use App\Repositories\Backend\Logs\LogsActivitysRepository;
use App\Repositories\Frontend\Company\EloquentCompanyRepository;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Session;
use Activity;
//require_once 'vendor/autoload.php';
/*use GeoIp2\Database\Reader;*/

class CompaniesController extends Controller
{
    /**
     * @var EloquentCompanyRepository
     */

    private $companyRepository;
    private $userLogs;
    /**
     * JobsController constructor.
     * @param EloquentCompanyRepository $companyRepository
     */

    public function __construct(EloquentCompanyRepository $companyRepository,LogsActivitysRepository $userLogs)
    {
        $this->companyRepository = $companyRepository;
        $this->userLogs=$userLogs;
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

        return view('frontend.companies.index' . ( env('APP_DESIGN') == 'new' ? 'new' : "" ),[
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
        $followingStatus='follow';
        if(!empty(auth()->user()->id)):
        if ( \DB::table('follow_companies')->where('company_id', $company->id)->where('user_id', auth()->user()->id)->count() ) :
                $followingStatus='following';
         endif;
        endif;

                return view('frontend.companies.company'.( env('APP_DESIGN') == 'new' ? 'new' : "" ),['company'	=>	$company,'followingStatus'	=>	$followingStatus]);




    }

    public function next($companyId){
        $nextCompanyUrlSlug = \DB::table('companies')->where('id', '<>', $companyId)->orderByRaw('RAND()')->value('url_slug');
        return redirect(route('companies.view', $nextCompanyUrlSlug));
    }

    public function followCompany(Request $request)
    {

        $companyId = $request->get('companyId');
        $companyName=Company::where('id',$companyId)->pluck('title');


        if (! \DB::table('follow_companies')->where('company_id', $companyId)->where('user_id', auth()->user()->id)->count() ) {
            \DB::table('follow_companies')->insert([
                'company_id'    => $companyId,
                'user_id'       => auth()->user()->id,
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()
            ]);
            \DB::table('companies')
                ->where('id',$companyId)
                ->increment('followers');
            $followerStatus='Following';

            $array['type'] = 'User';
            $array['heading']='with Name:'.auth()->user()->name.' is Following '.$companyName;
            $array['event'] = 'following';

            $name = $this->userLogs->getActivityDescriptionForEvent($array);
            Activity::log($name);
        }
     else
        {
         CompanyFollowers::where('user_id',auth()->user()->id)->delete();
         Company::where('id',$companyId)->decrement('followers');

            $followerStatus='Follow';

            $array['type'] = 'User';
            $array['heading']='with Name:'.auth()->user()->name.' is unfollowed '.$companyName;
            $array['event'] = 'unfollowed';

            $name = $this->userLogs->getActivityDescriptionForEvent($array);
            Activity::log($name);

        }
        $followers = Company::where('id',$companyId)->value('followers');

        return json_encode(['status'=>1,'followers'=>$followers,'followerStatus'=>$followerStatus]);

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
