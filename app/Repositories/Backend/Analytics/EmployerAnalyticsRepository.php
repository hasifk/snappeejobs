<?php

namespace App\Repositories\Backend\Analytics;


use App\Models\Access\User\CompanyVisitor;
use App\Models\Access\User\JobVisitor;
use App\Models\Company\Company;

use Illuminate\Http\Request;


class EmployerAnalyticsRepository
{



    public function getTotalCmpVisitors(Request $request)
    {
       $company_visitors=  CompanyVisitor::where('company_id', auth()->user()->company_id)
            ->whereNull('user_id')->paginate(10);
        return $company_visitors;
    }
   /***************************************************************************************************************/
    public function getTotalAuthCmpVisitors()
    {

        return  CompanyVisitor::join('users','users.id','=','company_visitors.user_id' )
            ->join('job_seeker_details', 'job_seeker_details.user_id','=','users.id')
            ->where('company_visitors.company_id',auth()->user()->company_id)
            ->select([
                'company_visitors.*',
                'users.*',
                \DB::raw('job_seeker_details.id as jobseeker')

            ])->paginate(10);

    }
    /***************************************************************************************************************/
    public function getTotalJobVisitors()
    {
        $company_id=auth()->user()->company_id;
        return JobVisitor::join('jobs','jobs.id','=','job_visitors.job_id')
            ->join('companies', function ($join) use ($company_id) {
                $join->on('companies.id', '=', 'jobs.company_id')
                    ->where('jobs.company_id', '=', $company_id);
            })->whereNull('job_visitors.user_id')
            ->select([
                'job_visitors.*',
                'jobs.title',
                'jobs.title_url_slug',
                'companies.url_slug'
            ])->paginate(10);
    }
    /***************************************************************************************************************/
    public function getTotalAuthJobVisitors()
    {
        return Company::join('jobs', 'jobs.company_id','=','companies.id')
            ->join('job_visitors', 'job_visitors.job_id','=','jobs.id')
            ->join('users', 'users.id','=','job_visitors.user_id')
            ->join('job_seeker_details', 'job_seeker_details.user_id','=','users.id')
            ->where('companies.id', '=', auth()->user()->company_id)
            ->select([
                'job_visitors.*',
                'jobs.title',
                'jobs.title_url_slug',
                'companies.url_slug',
                'users.name',
                \DB::raw('job_seeker_details.id as jobseeker')

            ])->paginate(10);
    }
    /***************************************************************************************************************/
    public function getUniqueJobVisitors()
    {
        return Company::join('jobs', 'jobs.company_id','=','companies.id')
            ->join('job_visitors', 'job_visitors.job_id','=','jobs.id')
            ->join('users', 'users.id','=','job_visitors.user_id')
            ->join('job_seeker_details', 'job_seeker_details.user_id','=','users.id')
            ->where('companies.id', '=', auth()->user()->company_id)
             ->groupBy('users.id')
            ->select(['job_visitors.*',\DB::raw('count(users.id) as visitors'),\DB::raw('job_seeker_details.id as jobseeker'),'jobs.title','jobs.title_url_slug','companies.url_slug','users.name'])
            ->paginate(10);
    }
    /***************************************************************************************************************/

    public function getUniqueCompanyVisitors()
    {

        return  CompanyVisitor::join('users','users.id','=','company_visitors.user_id' )
            ->join('job_seeker_details', 'job_seeker_details.user_id','=','users.id')
            ->where('company_visitors.company_id',auth()->user()->company_id)
            ->groupBy('users.id')
            ->select(['company_visitors.*',\DB::raw('count(users.id) as visitors'),\DB::raw('job_seeker_details.id as jobseeker'),'users.*'])->paginate(10);
    }

    /***************************************************************************************************************/

}
