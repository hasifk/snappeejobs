<?php namespace App\Repositories\Frontend\Company;

use App\Models\Access\User\ProfileVisitor;
use App\Models\JobSeeker\JobSeeker;
use Illuminate\Http\Request;
use App\Models\Company\Company;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use GeoIP;
/*use Illuminate\Support\Facades\Request;*/

/**
 * Class EloquentUserRepository
 * @package App\Repositories\User
 */
class EloquentCompanyRepository {

    public function getCompaniesPaginated(Request $request, $per_page, $order_by = 'companies.created_at', $sort = 'desc') {

        $searchObj = new Company();

        $jobseeker_industry_preferences = [];
        $jobseeker_size_preferences = '';
        // Get the job seeker's preferences
        if (  auth()->user() && (!empty(auth()->user()->job_seeker_details)) && auth()->user()->job_seeker_details->preferences_saved ) {
            $jobseeker = JobSeeker::find(auth()->user()->job_seeker_details->id);
            $jobseeker_industry_preferences = $jobseeker->industries->lists('id')->toArray();
            $jobseeker_size_preferences = $jobseeker->size;
        }

        // First the joins
        if ( $request->get('country_id') ) {
            $searchObj = $searchObj->where('companies.country_id', $request->get('country_id'));
        }
        if ( $request->get('state_id') ) {
            $searchObj = $searchObj->where('companies.state_id', $request->get('state_id'));
        }

        if ( $request->get('industries') || $jobseeker_industry_preferences ) {
            $searchObj = $searchObj->join('industry_company', 'industry_company.company_id', '=', 'companies.id');
        }

        if ( $request->get('industries') || $jobseeker_industry_preferences ) {
            if ( $request->get('industries') ) {
                $searchObj = $searchObj->whereIn('industry_company.industry_id', $request->get('industries'));
            } else if ( $jobseeker_industry_preferences ) {
                $searchObj = $searchObj->whereIn('industry_company.industry_id', $jobseeker_industry_preferences);
            }
        }

        if ( $request->get('companies') ) {
            $searchObj = $searchObj->whereIn('companies.id', $request->get('companies'));
        }

        if ( $request->get('size') || $jobseeker_size_preferences ) {
            if ( $request->get('size') ) {
                $searchObj = $searchObj->where('companies.size', $request->get('size'));
            } else {
                $searchObj = $searchObj->where('companies.size', $jobseeker_size_preferences);
            }
        }

        ( ($request->get('sort')) && ($request->get('sort') == 'likes') ) ? $order_by = $request->get('sort') : '';

        $companies =  $searchObj->with('people','photos','videos','socialmedia','industries')
            ->orderBy($order_by, $sort)
            ->groupBy('companies.id')
            ->skip((Paginator::resolveCurrentPage()-1)*($per_page))
            ->take($per_page)
            ->get();

        $paginator = $this->getCompaniesPaginator($request, $companies, $per_page);

        return [
            'companies'         => $companies,
            'paginator'         => $paginator
        ];

    }

    public function getCompaniesPaginator(Request $request, $companies, $perPage)
    {
        $curPage = Paginator::resolveCurrentPage();

        $searchObj = new Company();

        $jobseeker_industry_preferences = [];
        $jobseeker_size_preferences = '';
        // Get the job seeker's preferences
        if (  auth()->user() && (!empty(auth()->user()->job_seeker_details)) ) {
            $jobseeker = JobSeeker::find(auth()->user()->job_seeker_details->id);
            $jobseeker_industry_preferences = $jobseeker->industries->lists('id')->toArray();
            $jobseeker_size_preferences = $jobseeker->size;
        }

        // First the joins
        if ( $request->get('country_id') ) {
            $searchObj = $searchObj->where('companies.country_id', $request->get('country_id'));
        }
        if ( $request->get('state_id') ) {
            $searchObj = $searchObj->where('companies.state_id', $request->get('state_id'));
        }

        if ( $request->get('industries') || $jobseeker_industry_preferences ) {
            $searchObj = $searchObj->join('industry_company', 'industry_company.company_id', '=', 'companies.id');
        }

        if ( $request->get('industries') || $jobseeker_industry_preferences ) {
            if ( $request->get('industries') ) {
                $searchObj = $searchObj->whereIn('industry_company.industry_id', $request->get('industries'));
            } else {
                $searchObj = $searchObj->whereIn('industry_company.industry_id', $jobseeker_industry_preferences);
            }
        }

        if ( $request->get('companies') ) {
            $searchObj = $searchObj->whereIn('companies.id', $request->get('companies'));
        }

        if ( $request->get('size') || $jobseeker_size_preferences ) {
            if ( $request->get('size') ) {
                $searchObj = $searchObj->where('companies.size', $request->get('size'));
            } else {
                $searchObj = $searchObj->where('companies.size', $jobseeker_size_preferences);
            }
        }

        $companies =  $searchObj->with('people','photos','videos','socialmedia','industries')
            ->groupBy('companies.id');

        $companies_count = $searchObj->select([
            \DB::raw('companies.id AS company_id'), \DB::raw('count(*) as total')
        ]);

        $companies_count = \DB::table( \DB::raw("({$companies_count->toSql()}) as sub") )
            ->mergeBindings($companies_count->getQuery()) // you need to get underlying Query Builder
            ->count();

        $paginator = new LengthAwarePaginator(
            $companies, $companies_count, $perPage, $curPage,
            ['path' => Paginator::resolveCurrentPath()]
        );

        $paginator->appends($request->except(['page']));

        return $paginator;

    }

    public function getCompanyBySlug($slug)
    {
        return Company::with('people','photos','videos','socialmedia','industries')
        ->where('companies.url_slug',$slug)->first();
    }

    public function storeCompanyvisits($slug,$current_ip)
    {
        $location = GeoIP::getLocation($current_ip);
        if(!empty($location)):
            $cmp_id=Company::where('url_slug',$slug)->pluck('id') ;
            $store_visitor=new ProfileVisitor();
            $store_visitor->company_id = $cmp_id;
            $store_visitor->country    = $location['country'];
            $store_visitor->state      = $location['state'];
            $store_visitor->latitude   = $location['lat'];;
            $store_visitor->longitude  = $location['lon'];;
            $store_visitor->save();
            return 'true';
        endif;


    }


}
