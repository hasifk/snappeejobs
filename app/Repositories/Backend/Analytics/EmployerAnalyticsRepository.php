<?php

namespace App\Repositories\Backend\Analytics;


use App\Models\Access\User\CompanyVisitor;
use App\Models\Access\User\JobVisitor;
use App\Models\Company\Company;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;


class EmployerAnalyticsRepository
{



    public function getTotalCmpVisitors(Request $request)
    {
       $company_visitors=  CompanyVisitor::where('company_id', auth()->user()->company_id)
            ->whereNull('user_id')->paginate(10);
      // $paginator = $this->getPaginator($request,$company_visitors, count($company_visitors), 1);
       // $company_visitors=$company_visitors->paginate(2);
        /*return [
            'company_visitors'         => $company_visitors,
            'paginator'         => $paginator
        ];*/
        return $company_visitors;
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
    public function getPaginator(Request $request,$obj,$count,$limit)
    {
        $curPage = Paginator::resolveCurrentPage();


        $paginator = new LengthAwarePaginator(
            $obj, $count, $limit, $curPage,
            ['path' => Paginator::resolveCurrentPath()]
        );

        $paginator->appends($request->except(['page']));

        return $paginator;

    }

    /***************************************************************************************************************/



}
