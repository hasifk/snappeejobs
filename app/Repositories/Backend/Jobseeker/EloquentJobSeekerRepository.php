<?php namespace App\Repositories\Backend\JobSeeker;

use App\Models\JobSeeker\JobSeeker;
use App\Models\JobSeeker\JobSeekerVideoLinks;
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

        // Joining the job applications
        $searchObj = $searchObj->join('job_applications', 'job_applications.user_id', '=', 'users.id', 'left');
        $searchObj = $searchObj->join('jobs', 'jobs.id', '=', 'job_applications.job_id', 'left');

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
            ->where('users.status', true)
            ->where('users.confirmed', true)
            ->where('jobs.company_id', auth()->user()->company_id)
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

        // Joining the job applications
        $searchObj = $searchObj->join('job_applications', 'job_applications.user_id', '=', 'users.id');
        $searchObj = $searchObj->join('jobs', 'jobs.id', '=', 'job_applications.job_id');

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
            ->where('jobs.company_id', auth()->user()->company_id)
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
/****************************************************************************************************/
    public function storeJobSeekerVideoLink($link)
    {
        $youtube_id=$vimeo_id='';
        if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $link, $match))
        {
            $youtube_id=$match[1];
        }
        if (preg_match('/(https?:\/\/)?(www\.)?(player\.)?vimeo\.com\/([a-z]*\/)*([0-9]{6,11})[?]?.*/', $link, $match))
        {
            $vimeo_id = $match[5];
        }

        // Deleteing the old link
        \DB::table('job_seeker_video_links')->where('user_id', auth()->user()->jobseeker_details->id)->delete();

           $jobSeeker = auth()->user()->jobseeker_details;
           $store_videolink=new JobSeekerVideoLinks;
            $store_videolink->user_id=$jobSeeker->id;
            $store_videolink->youtube_id=$youtube_id;
            $store_videolink->vimeo_id=$vimeo_id;
            $store_videolink->save();
            return "Video Link Saved Successfully";



    }
    /*********************************************************************************************************/
}
