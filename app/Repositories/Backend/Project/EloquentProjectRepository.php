<?php

namespace App\Repositories\Backend\Project;


use Illuminate\Contracts\Auth\Guard;

class EloquentProjectRepository
{

    /**
     * @var Guard
     */
    private $user;

    public function __construct(Guard $user)
    {

        $this->user = $user;
    }

    public function getEmployers(){
        return \DB::table('staff_employer')
            ->join('users', 'staff_employer.user_id', '=', 'users.id')
            ->where('staff_employer.employer_id', '=', $this->user->user()->employer_id)
            ->select(['users.id', 'users.name'])
            ->get();
    }

    public function getJobListings(){
        $company_id = \DB::table('companies')->where('employer_id', $this->user->user()->employer_id)->value('id');
        return \DB::table('jobs')
            ->where('jobs.company_id', '=', $company_id)
            ->select(['jobs.id', 'jobs.title'])
            ->get();
    }

}
