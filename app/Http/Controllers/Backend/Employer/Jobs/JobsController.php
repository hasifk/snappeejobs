<?php

namespace App\Http\Controllers\Backend\Employer\Jobs;

use App\Repositories\Backend\Job\EloquentJobRepository;
use App\Repositories\Backend\Permission\PermissionRepositoryContract;
use App\Repositories\Backend\Role\RoleRepositoryContract;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class JobsController extends Controller
{
    /**
     * @var EloquentJobRepository
     */
    private $jobs;
    /**
     * @var RoleRepositoryContract
     */
    private $roles;
    /**
     * @var PermissionRepositoryContract
     */
    private $permissions;

    /**
     * JobsController constructor.
     * @param EloquentJobRepository $jobs
     * @param RoleRepositoryContract $roles
     * @param PermissionRepositoryContract $permissions
     */
    public function __construct(EloquentJobRepository $jobs, RoleRepositoryContract $roles, PermissionRepositoryContract $permissions)
    {
        $this->jobs = $jobs;
        $this->roles = $roles;
        $this->permissions = $permissions;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('backend.employer.jobs.index')
            ->withJobs($this->jobs->getJobsPaginated(config('jobs.default_per_page'), 1));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
