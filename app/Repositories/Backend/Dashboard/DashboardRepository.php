<?php

namespace App\Repositories\Backend\Dashboard;


use App\Models\Access\User\CompanyVisitor;
use App\Models\Access\User\JobVisitor;
use App\Models\Company\Company;
use App\Models\Company\Notifications\EmployerNotification;
use App\Models\Job\Job;
use App\Models\Access\User\User;
use App\Models\JobSeeker\JobSeeker;
use Carbon\Carbon;


class DashboardRepository
{

    public function getEmployerCount(){
        return \DB::table('employer_plan')->count();
    }
/**************************************************************************************************************/
    public function getActiveSubscriptionCount(){

        return \DB::table('employer_plan')
            ->join('users', 'users.id', '=', 'employer_plan.employer_id')
            ->whereNull('users.subscription_ends_at')
            ->orWhere('users.subscription_ends_at', '>', Carbon::now()->toDateTimeString() )
            ->count();
    }
    /**************************************************************************************************************/
    public function getBlockedUsersCount(){
        return \DB::table('users')->where('status', 2)->count();
    }
    /**************************************************************************************************************/
    public function getActiveJobListingCount(){
        return \DB::table('jobs')->where('status', true)->count();
    }
    /**************************************************************************************************************/
    public function getTotalJobsPostedCount(){
        if ( is_null(auth()->user()->companyId) ) {
            return 0;
        }
        return \DB::table('jobs')->where('company_id', auth()->user()->companyId )->count();
    }
    /**************************************************************************************************************/
    public function getTotalJobsApplicationsCount(){
        return \DB::table('job_applications')
            ->join('jobs', 'jobs.id', '=', 'job_applications.job_id')
            ->where('jobs.company_id', auth()->user()->companyId )
            ->count();
    }
    /**************************************************************************************************************/
    public function getTotalStaffMembersCount(){
        return \DB::table('staff_employer')
            ->where('employer_id', auth()->user()->employer_id)
            ->count();
    }
    /**************************************************************************************************************/
    public function employerNotifications(){

        $notifications = EmployerNotification
            ::where('employer_id', auth()->user()->employer_id)
            ->where('user_id', auth()->user()->id)
            ->paginate(10);

        return $notifications;
    }
    /**************************************************************************************************************/
    public function newsFeedsNotifications(){

        $notifications = EmployerNotification::where('from_admin',1)->where('user_id', auth()->user()->id)
            ->paginate(10);

        return $notifications;
    }
    /**************************************************************************************************************/
    public function getNewsfeedNotifications()
    {
        $newsfeed_notifications = \DB::table('employer_notifications')
            ->where('user_id', auth()->user()->id)
            ->get();

        return $newsfeed_notifications;
    }
    /**************************************************************************************************************/
    public function getTotalNewMessagesCount(){
        $unread_count = \DB::table('thread_participants')
            ->join('threads','thread_participants.thread_id','=','threads.id')
            ->join('users','thread_participants.sender_id','=','users.id')
            ->whereNull('thread_participants.deleted_at')
            ->whereNull('thread_participants.read_at')
            ->where('thread_participants.user_id',auth()->user()->id)
            ->count();

        return $unread_count;
    }

    /**************************************************************************************************************/
        public function getTotalCmpVisitorsCount()
        {
            return  CompanyVisitor::where('company_id', auth()->user()->company_id)
                ->count();
        }
    /**************************************************************************************************************/
    public function getTotalJobVisitorsCount()
    {
        return Company::join('jobs', 'jobs.company_id','=','companies.id')
            ->join('job_visitors', 'job_visitors.job_id','=','jobs.id')
            ->where('companies.id', '=', auth()->user()->company_id)
            ->select([
                'job_visitors.*',
            ])->count();
    }
    /**************************************************************************************************************/
        public function getActiveJobListingCount1(){
            return Job::where('status', true)->where('company_id', auth()->user()->company_id)->count();
        }
    /**************************************************************************************************************/
        public function getEmployerNotifications(){
                $employer_notifications = \DB::table('employer_notifications')
                    ->where('employer_id', auth()->user()->employer_id)
                    ->where('user_id', auth()->user()->id)
                    ->get();

                return $employer_notifications;
        }
    /**************************************************************************************************************/
        public function getThumbsUpsCount(){
                return Company::where('id', auth()->user()->company_id)->pluck('followers');
        }
    /**************************************************************************************************************/
    public function getCompanyInterestMapInfo(){
       return CompanyVisitor::where('company_id', auth()->user()->company_id)->get();

    }

    /**************************************************************************************************************/

    public function getTodaysJobVisitorsCount()
    {
        return Company::join('jobs', 'jobs.company_id','=','companies.id')
            ->join('job_visitors', 'job_visitors.job_id','=','jobs.id')
            ->where('companies.id', '=', auth()->user()->company_id)
            ->whereRaw('DATE(job_visitors.created_at) = CURRENT_DATE')
            ->select([
                'job_visitors.*',
            ])->count();
    }
    /**************************************************************************************************************/

    public function getJobInterestLevel()
    {
        return Company::join('jobs', 'jobs.company_id','=','companies.id')
            ->join('job_visitors', 'job_visitors.job_id','=','jobs.id')
            ->where('companies.id', '=', auth()->user()->company_id)
            ->whereRaw('DATE(job_visitors.created_at) = CURRENT_DATE')->groupBy('jobs.id')
            ->get(['job_visitors.*',\DB::raw('count(jobs.id) as items'),'jobs.title']);

    }
    /**************************************************************************************************************/
    public function getJobSeekerCount(){
        return JobSeeker::count();
    }
    /**************************************************************************************************************/

}
