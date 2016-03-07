<?php namespace App\Repositories\Frontend\Index;

use App\Models\Access\User\User;
use App\Models\Job\Job;
use App\Models\JobSeeker\JobSeeker;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

/**
 * Class EloquentUserRepository
 * @package App\Repositories\User
 */
class EloquentIndexRepository {

    public function getprefJobsPaginated(Request $request, $per_page, $order_by = 'jobs.created_at', $sort = 'desc') {

        $searchObj = new Job();


        $jobseeker_category_preferences = [];
        $jobseeker_skill_preferences = '';
        // Get the job seeker's preferences
        if (  auth()->user() && (!empty(auth()->user()->job_seeker_details)) ) {
            $jobseeker = JobSeeker::find(auth()->user()->job_seeker_details->id);
            $jobseeker_category_preferences = $jobseeker->categories->lists('id')->toArray();
            $jobseeker_skill_preferences = $jobseeker->skills->lists('id')->toArray();
        }

        // First the joins
        if ( $request->get('companies') ) {
            $searchObj = $searchObj->join('companies', 'companies.id', '=', 'jobs.company_id');
        }
        if ( $request->get('categories') || $jobseeker_category_preferences ) {
            $searchObj = $searchObj->join('category_preferences_jobs', 'category_preferences_jobs.job_id', '=', 'jobs.id');
        }
        if ( $request->get('skills') || $jobseeker_skill_preferences ) {
            $searchObj = $searchObj->join('job_skills', 'job_skills.job_id', '=', 'jobs.id');
        }

        // then the where conditions
        if ( $request->get('level') ) {
            $searchObj = $searchObj->where('jobs.level', $request->get('level'));
        }
        if ( $request->get('companies') ) {
            $searchObj = $searchObj->whereIn('jobs.company_id', $request->get('companies'));
        }
        if ( $request->get('categories') || $jobseeker_category_preferences ) {
            if ( $request->get('categories') ) {
                $searchObj = $searchObj->whereIn('category_preferences_jobs.job_category_id', $request->get('categories'));
            } else {
                $searchObj = $searchObj->whereIn('category_preferences_jobs.job_category_id', $jobseeker_category_preferences);
            }
        }
        if ( $request->get('skills') || $jobseeker_skill_preferences ) {
            if ($request->get('skills')) {
                $searchObj = $searchObj->whereIn('job_skills.skill_id', $request->get('skills'));
            } else {
                $searchObj = $searchObj->whereIn('job_skills.skill_id', $jobseeker_skill_preferences);
            }
        }
        if ( $request->get('country_id') ) {
            $searchObj = $searchObj->where('jobs.country_id', $request->get('country_id'));
        }
        if ( $request->get('state_id') ) {
            $searchObj = $searchObj->where('jobs.state_id', $request->get('state_id'));
        }

        if ( $request->get('pref_jobs') ) {
            if ( auth()->user() && (!empty(auth()->user()->job_seeker_details)) ) {
                $searchObj1 = DB::table('job_seeker_details')
                    ->join('category_preferences_job_seeker', 'category_preferences_job_seeker.user_id', '=', 'job_seeker_details.id')
                    ->join('category_preferences_jobs', 'category_preferences_jobs.job_category_id', '=', 'category_preferences_job_seeker.job_category_id')
                    ->join('jobs', 'jobs.id', '=', 'category_preferences_jobs.job_id')
                    ->where('job_seeker_details.id', '=', auth()->user()->job_seeker_details->id)
                    ->select([
                        'jobs.*',

                    ])
                    ->get();
                $searchObj = $searchObj->merge($searchObj1);
                //$searchObj=$searchObj->$searchobj1;
            }
        }

        $searchObj = $searchObj
            ->where('jobs.status', true)
            ->where('jobs.published', true)
            ->groupBy('jobs.id');

        ( ($request->get('sort')) && ($request->get('sort') == 'likes') ) ? $order_by = $request->get('sort') : '';

        $jobs_pref = $searchObj
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
                'jobs.created_at',
                'jobs.paid_expiry'
            ])
            ->get();

       // $paginator = $this->getJobsPaginator($request, $jobs, $per_page);

        return [
            'jobs_pref'              => $jobs_pref,
        ];

    }






}
