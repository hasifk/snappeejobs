<?php

namespace App\Repositories\Backend\Dashboard;


use Carbon\Carbon;

class DashboardRepository
{

    public function getEmployerCount(){
        return \DB::table('employer_plan')->count();
    }

    public function getActiveSubscriptionCount(){

        return \DB::table('employer_plan')
            ->join('users', 'users.id', '=', 'employer_plan.employer_id')
            ->whereNull('users.subscription_ends_at')
            ->orWhere('users.subscription_ends_at', '>', Carbon::now()->toDateTimeString() )
            ->count();
    }

    public function getBlockedUsersCount(){
        return \DB::table('users')->where('status', 2)->count();
    }

    public function getActiveJobListingCount(){
        return \DB::table('jobs')->where('status', true)->count();
    }

    public function getTotalJobsPostedCount(){
        return \DB::table('jobs')->count();
    }

    public function getTotalJobsApplicationsCount(){
        return \DB::table('job_applications')->count();;
    }

    public function getTotalStaffMembersCount(){
        return \DB::table('staff_employer')
            ->where('employer_id', auth()->user()->employer_id)
            ->count();
    }

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

}