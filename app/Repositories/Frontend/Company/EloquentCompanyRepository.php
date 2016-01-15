<?php namespace App\Repositories\Frontend\Company;

use App\Models\Company\Company;
use Illuminate\Support\Facades\Request;

/**
 * Class EloquentUserRepository
 * @package App\Repositories\User
 */
class EloquentCompanyRepository {

    public function getCompaniesPaginated(Request $request, $per_page, $order_by = 'companies.id', $sort = 'asc') {

        $searchObj = new Company();

        // First the joins
        /*if ( $request->get('locations') ) {
            $searchObj = $searchObj->join('states', 'states.id', '=', 'jobs.id');
        }
        if ( $request->get('skills') ) {
            $searchObj = $searchObj->join('job_skills', 'job_skills.job_id', '=', 'jobs.id');
        }*/

        return Company::with('people','photos','videos','socialmedia','industries')
            ->orderBy($order_by, $sort)
            ->groupBy()
            ->paginate($per_page);

    }

    public function getCompanyBySlug($slug)
    {
        return Company::with('people','photos','videos','socialmedia','industries')
        ->where('companies.url_slug',$slug)->first();
    }

}