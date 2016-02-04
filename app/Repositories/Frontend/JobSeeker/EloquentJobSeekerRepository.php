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
        if ( $request->get('categories') ) {
            $searchObj = $searchObj->join('category_preferences_job_seeker', 'category_preferences_job_seeker.user_id', '=', 'job_seeker_details.user_id');
        }
        if ( $request->get('skills') ) {
            $searchObj = $searchObj->join('skills_job_seeker', 'skills_job_seeker.user_id', '=', 'job_seeker_details.user_id');
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
            ->where('users.confirmed', true);

        ( ($request->get('sort')) && ($request->get('sort') == 'likes') ) ? $order_by = $request->get('sort') : '';

        $jobSeekerObject = $searchObj
            ->with('user', 'country', 'state', 'skills')
            ->orderBy($order_by, $sort)
            ->select([
                'job_seeker_details.id',
                'job_seeker_details.user_id',
                'job_seeker_details.country_id',
                'job_seeker_details.state_id',
                'job_seeker_details.size',
                'job_seeker_details.likes'
            ]);

        return $jobSeekerObject->paginate();

    }

}
