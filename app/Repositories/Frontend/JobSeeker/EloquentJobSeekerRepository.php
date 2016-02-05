<?php namespace App\Repositories\Frontend\JobSeeker;

use App\Models\JobSeeker\JobSeeker;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

/**
 * Class EloquentUserRepository
 * @package App\Repositories\User
 */
class EloquentJobSeekerRepository {

    public function getJobsSeekersPaginated(Request $request, $per_page, $order_by = 'users.created_at', $sort = 'desc') {

        $searchObj = new JobSeeker();

        $searchObj = $searchObj->join('users', 'users.id', '=', 'job_seeker_details.user_id');

        // First the joins
        if ( $request->get('categories') ) {
            $searchObj = $searchObj->join('category_preferences_job_seeker', 'category_preferences_job_seeker.user_id', '=', 'job_seeker_details.id');
        }
        if ( $request->get('skills') ) {
            $searchObj = $searchObj->join('skills_job_seeker', 'skills_job_seeker.user_id', '=', 'job_seeker_details.id');
        }

        // then the where conditions
        if ( $request->get('size') ) {
            $searchObj = $searchObj->where('job_seeker_details.size', $request->get('size'));
        }
        if ( $request->get('categories') ) {
            $searchObj = $searchObj->whereIn('category_preferences_job_seeker.job_category_id', $request->get('categories'));
        }
        if ( $request->get('skills') ) {
            $searchObj = $searchObj->whereIn('skills_job_seeker.skill_id', $request->get('skills'));
        }
        if ( $request->get('country_id') ) {
            $searchObj = $searchObj->where('job_seeker_details.country_id', $request->get('country_id'));
        }
        if ( $request->get('state_id') ) {
            $searchObj = $searchObj->where('job_seeker_details.state_id', $request->get('state_id'));
        }

        $searchObj = $searchObj
            ->where('job_seeker_details.has_resume', true)
            ->where('job_seeker_details.preferences_saved', true)
            ->where('users.status', true)
            ->where('users.confirmed', true)
            ->groupBy('job_seeker_details.id');

        ( ($request->get('sort')) && ($request->get('sort') == 'likes') ) ? $order_by = $request->get('sort') : '';

        $jobSeekers = $searchObj
            ->with('user', 'country', 'state', 'skills', 'categories')
            ->orderBy($order_by, $sort)
            ->skip((Paginator::resolveCurrentPage()-1)*($per_page))
            ->take($per_page)
            ->select([
                'job_seeker_details.id',
                'job_seeker_details.user_id',
                'job_seeker_details.country_id',
                'job_seeker_details.state_id',
                'job_seeker_details.size',
                'job_seeker_details.likes'
            ])->get();

        $paginator = $this->getJobSeekerPaginator($request, $jobSeekers, $per_page);

        return [
            'jobseekers'              => $jobSeekers,
            'paginator'               => $paginator
        ];

    }

    private function getJobSeekerPaginator($request, $jobSeekers, $per_page)
    {
        $curPage = Paginator::resolveCurrentPage();

        $searchObj = new JobSeeker();

        $searchObj = $searchObj->join('users', 'users.id', '=', 'job_seeker_details.user_id');

        // First the joins
        if ( $request->get('categories') ) {
            $searchObj = $searchObj->join('category_preferences_job_seeker', 'category_preferences_job_seeker.user_id', '=', 'job_seeker_details.id');
        }
        if ( $request->get('skills') ) {
            $searchObj = $searchObj->join('skills_job_seeker', 'skills_job_seeker.user_id', '=', 'job_seeker_details.id');
        }

        // then the where conditions
        if ( $request->get('size') ) {
            $searchObj = $searchObj->where('job_seeker_details.size', $request->get('size'));
        }
        if ( $request->get('categories') ) {
            $searchObj = $searchObj->whereIn('category_preferences_job_seeker.job_category_id', $request->get('categories'));
        }
        if ( $request->get('skills') ) {
            $searchObj = $searchObj->whereIn('skills_job_seeker.skill_id', $request->get('skills'));
        }
        if ( $request->get('country_id') ) {
            $searchObj = $searchObj->where('job_seeker_details.country_id', $request->get('country_id'));
        }
        if ( $request->get('state_id') ) {
            $searchObj = $searchObj->where('job_seeker_details.state_id', $request->get('state_id'));
        }

        $searchObj = $searchObj
            ->where('job_seeker_details.has_resume', true)
            ->where('job_seeker_details.preferences_saved', true)
            ->where('users.status', true)
            ->where('users.confirmed', true)
            ->groupBy('job_seeker_details.id');

        $jobseeker_count = $searchObj->select([
            \DB::raw('job_seeker_details.id AS jobseeker_id'), \DB::raw('count(*) as total')
        ]);

        $jobseeker_count = \DB::table( \DB::raw("({$jobseeker_count->toSql()}) as sub") )
            ->mergeBindings($jobseeker_count->getQuery()) // you need to get underlying Query Builder
            ->count();

        $paginator = new LengthAwarePaginator(
            $jobSeekers, $jobseeker_count, $per_page, $curPage,
            ['path' => Paginator::resolveCurrentPath()]
        );

        $paginator->appends($request->except(['page']));

        return $paginator;
    }

}
