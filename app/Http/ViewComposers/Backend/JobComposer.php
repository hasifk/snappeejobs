<?php

namespace app\Http\ViewComposers\Backend;

use Illuminate\Contracts\View\View;

/**
 * Class JobComposer
 *
 * @package \app\Http\ViewComposers\Backend
 */
class JobComposer
{

    public function compose(View $view){

        $jobApplicationsCount = \DB::table('job_applications')
            ->join('jobs', 'jobs.id', '=', 'job_applications.job_id')
            ->where('jobs.company_id', auth()->user()->companyId )->count();

        $jobApplications = \DB::table('job_applications')
            ->join('jobs', 'jobs.id', '=', 'job_applications.job_id')
            ->join('users', 'job_applications.user_id', '=', 'users.id')
            ->where('jobs.company_id', auth()->user()->companyId )
            ->where(function($query){
                $query->whereNull('job_applications.accepted_at' )
                      ->orWhereNull('job_applications.declined_at');
            })
            ->select([
                'job_applications.id',
                'jobs.title',
                'users.name',
                \DB::raw('users.id AS user_id'),
                'job_applications.created_at'
            ])
            ->get();

        $view->with('unread_job_applications_count', $jobApplicationsCount);

        if ( $jobApplicationsCount ) {
            $view->with('job_applications', $jobApplications);
        }
    }
}
