<?php namespace App\Repositories\Frontend\Company;

use Illuminate\Http\Request;
use App\Models\Company\Company;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
/*use Illuminate\Support\Facades\Request;*/

/**
 * Class EloquentUserRepository
 * @package App\Repositories\User
 */
class EloquentCompanyRepository {

    public function getCompaniesPaginated(Request $request, $per_page, $order_by = 'companies.created_at', $sort = 'asc') {

        $searchObj = new Company();

        // First the joins
        if ( $request->get('locations') ) {
            $searchObj = $searchObj->join('states', 'states.id', '=', 'companies.id');
        }

        if ( $request->get('industries') ) {
            $searchObj = $searchObj->join('industry_company', 'industry_company.company_id', '=', 'companies.id');
        }

        // then the where conditions
        if ( $request->get('locations') ) {
            $searchObj = $searchObj->whereIn('states.id', $request->get('locations'));
        }

        if ( $request->get('industries') ) {
            $searchObj = $searchObj->whereIn('industry_company.industry_id', $request->get('industries'));
        }

        if ( $request->get('companies') ) {
            $searchObj = $searchObj->whereIn('companies.id', $request->get('companies'));
        }

        if ( $request->get('size') ) {
            $searchObj = $searchObj->where('companies.size', $request->get('size'));
        }

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

        // First the joins
        if ( $request->get('locations') ) {
            $searchObj = $searchObj->join('states', 'states.id', '=', 'companies.id');
        }
        if ( $request->get('industries') ) {
            $searchObj = $searchObj->join('industry_company', 'industry_company.company_id', '=', 'companies.id');
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

}