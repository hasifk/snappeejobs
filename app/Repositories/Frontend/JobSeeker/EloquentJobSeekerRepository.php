<?php namespace App\Repositories\Frontend\JobSeeker;

use App\Models\JobSeeker\JobSeeker;
use Illuminate\Http\Request;

/**
 * Class EloquentUserRepository
 * @package App\Repositories\User
 */
class EloquentJobSeekerRepository {

    public function getJobsSeekersPaginated(Request $request, $per_page, $order_by = 'users.created_at', $sort = 'desc') {

        $searchObj = new JobSeeker();

        $searchObj = $searchObj->join('users', 'users.id', '=', 'job_seeker_details.user_id');

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
            ->where('job_seeker_details.has_resume', true)
            ->where('job_seeker_details.preferences_saved', true)
            ->where('users.status', true)
            ->where('users.confirmed', true);

        ( ($request->get('sort')) && ($request->get('sort') == 'likes') ) ? $order_by = $request->get('sort') : '';

        return $searchObj->paginate();

    }

}
