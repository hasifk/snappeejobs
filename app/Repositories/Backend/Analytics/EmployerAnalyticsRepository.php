<?php

namespace App\Repositories\Backend\Analytics;


use App\Models\Access\User\CompanyVisitor;
use App\Models\Access\User\JobVisitor;
use App\Models\Company\Company;


class EmployerAnalyticsRepository
{



    public function getTotalCmpVisitors()
    {
        return  CompanyVisitor::where('company_id', auth()->user()->company_id)
            ->whereNull('user_id')->get();
    }
   /***************************************************************************************************************/
    public function getTotalAuthCmpVisitors()
    {

        return  CompanyVisitor::join('users','users.id','=','company_visitors.user_id' )
            ->where('company_visitors.company_id',auth()->user()->company_id)
            ->select([
                'company_visitors.*',
                'users.*'

            ])->get();

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
            ])->get();
    }
    /***************************************************************************************************************/
    public function getTotalAuthJobVisitors()
    {
        return Company::join('jobs', 'jobs.company_id','=','companies.id')
            ->join('job_visitors', 'job_visitors.job_id','=','jobs.id')
            ->join('users', 'users.id','=','job_visitors.user_id')
            ->where('companies.id', '=', auth()->user()->company_id)
            ->select([
                'job_visitors.*',
                'jobs.title',
                'jobs.title_url_slug',
                'companies.url_slug',
                'users.name'

            ])->get();
    }
    /***************************************************************************************************************/
    public function getUniqueJobVisitors()
    {
        return Company::join('jobs', 'jobs.company_id','=','companies.id')
            ->join('job_visitors', 'job_visitors.job_id','=','jobs.id')
            ->join('users', 'users.id','=','job_visitors.user_id')
            ->where('companies.id', '=', auth()->user()->company_id)
             ->groupBy('users.id')
            ->get(['job_visitors.*',\DB::raw('count(users.id) as visitors'),'jobs.title','jobs.title_url_slug','companies.url_slug','users.name']);
    }
    /***************************************************************************************************************/

    public function getUniqueCompanyVisitors()
    {

        return  CompanyVisitor::join('users','users.id','=','company_visitors.user_id' )
            ->where('company_visitors.company_id',auth()->user()->company_id)
            ->groupBy('users.id')
            ->get(['company_visitors.*',\DB::raw('count(users.id) as visitors'),'users.*']);
    }

    /***************************************************************************************************************/



}
