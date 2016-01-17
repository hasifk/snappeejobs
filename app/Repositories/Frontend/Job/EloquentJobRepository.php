<?php namespace App\Repositories\Frontend\Job;

use App\Models\Job\Job;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

/**
 * Class EloquentUserRepository
 * @package App\Repositories\User
 */
class EloquentJobRepository {

    public function getJobsPaginated(Request $request, $per_page, $order_by = 'jobs.created_at', $sort = 'desc') {

        $searchObj = new Job();

        // First the joins
        if ( $request->get('companies') ) {
            $searchObj = $searchObj->join('companies', 'companies.id', '=', 'jobs.company_id');
        }
        if ( $request->get('categories') ) {
            $searchObj = $searchObj->join('category_preferences_jobs', 'category_preferences_jobs.job_id', '=', 'jobs.id');
        }
        if ( $request->get('skills') ) {
            $searchObj = $searchObj->join('job_skills', 'job_skills.job_id', '=', 'jobs.id');
        }

        // then the where conditions
        if ( $request->get('level') ) {
            $searchObj = $searchObj->where('jobs.level', $request->get('level'));
        }
        if ( $request->get('companies') ) {
            $searchObj = $searchObj->whereIn('jobs.company_id', $request->get('companies'));
        }
        if ( $request->get('categories') ) {
            $searchObj = $searchObj->whereIn('category_preferences_jobs.job_category_id', $request->get('categories'));
        }
        if ( $request->get('skills') ) {
            $searchObj = $searchObj->whereIn('job_skills.skill_id', $request->get('skills'));
        }
        if ( $request->get('country_id') ) {
            $searchObj = $searchObj->where('jobs.country_id', $request->get('country_id'));
        }
        if ( $request->get('state_id') ) {
            $searchObj = $searchObj->where('jobs.state_id', $request->get('state_id'));
        }

        $searchObj = $searchObj
            ->where('jobs.status', true)
            ->where('jobs.published', true)
            ->groupBy('jobs.id');

        ( ($request->get('sort')) && ($request->get('sort') == 'likes') ) ? $order_by = $request->get('sort') : '';

        $jobs = $searchObj
            ->with('categories', 'skills', 'company', 'country', 'state')
            ->orderBy($order_by, $sort)
            ->skip((Paginator::resolveCurrentPage()-1)*($per_page))
            ->take($per_page)
            ->select([
                'jobs.id',
                'jobs.company_id',
                'jobs.title',
                'jobs.title_url_slug',
                'jobs.level',
                'jobs.country_id',
                'jobs.state_id',
                'jobs.likes',
                'jobs.created_at'
            ])
            ->get();

        $paginator = $this->getJobsPaginator($request, $jobs, $per_page);

        return [
            'jobs'              => $jobs,
            'paginator'         => $paginator
        ];

    }

    public function getJobsPaginator(Request $request, $jobs, $perPage){

        $curPage = Paginator::resolveCurrentPage();

        $searchObj = new Job();

        // First the joins
        if ( $request->get('categories') ) {
            $searchObj = $searchObj->join('category_preferences_jobs', 'category_preferences_jobs.job_id', '=', 'jobs.id');
        }
        if ( $request->get('skills') ) {
            $searchObj = $searchObj->join('job_skills', 'job_skills.job_id', '=', 'jobs.id');
        }

        // then the where conditions
        if ( $request->get('level') ) {
            $searchObj = $searchObj->where('jobs.level', $request->get('level'));
        }
        if ( $request->get('categories') ) {
            $searchObj = $searchObj->whereIn('category_preferences_jobs.job_category_id', $request->get('categories'));
        }
        if ( $request->get('skills') ) {
            $searchObj = $searchObj->whereIn('job_skills.skill_id', $request->get('skills'));
        }
        if ( $request->get('country_id') ) {
            $searchObj = $searchObj->where('jobs.country_id', $request->get('country_id'));
        }
        if ( $request->get('state_id') ) {
            $searchObj = $searchObj->where('jobs.state_id', $request->get('state_id'));
        }

        $searchObj = $searchObj
            ->where('jobs.status', true)
            ->where('jobs.published', true)
            ->groupBy('jobs.id');

        $jobs_count = $searchObj->select([
            \DB::raw('jobs.id AS job_id'), \DB::raw('count(*) as total')
        ]);

        $jobs_count = \DB::table( \DB::raw("({$jobs_count->toSql()}) as sub") )
            ->mergeBindings($jobs_count->getQuery()) // you need to get underlying Query Builder
            ->count();

        $paginator = new LengthAwarePaginator(
            $jobs, $jobs_count, $perPage, $curPage,
            ['path' => Paginator::resolveCurrentPath()]
        );

        $paginator->appends($request->except(['page']));

        return $paginator;
    }

}