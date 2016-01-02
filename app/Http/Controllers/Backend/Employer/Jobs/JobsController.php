<?php

namespace App\Http\Controllers\Backend\Employer\Jobs;

use App\Http\Requests\Backend\Employer\Job\HideJobRequest;
use App\Http\Requests\Backend\Employer\Job\MarkJobRequest;
use App\Http\Requests\Backend\Employer\Job\PublishJobRequest;
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
    public function create(Requests\Backend\Employer\Job\CreateJobPageViewRequest $request)
    {
        $job_categories = \DB::table('job_categories')->select(['id', 'name'])->get();
        $countries = \DB::table('countries')->select(['id', 'name'])->get();

        if ( $request->old('country_id') ) {
            $states = \DB::table('states')
                ->where('country_id', $request->old('country_id'))
                ->select(['id', 'name'])
                ->get();
        } else {
            $states = \DB::table('states')
                ->where('country_id', 222)
                ->select(['id', 'name'])
                ->get();
        }

        $view = [
            'countries'         => $countries,
            'states'            => $states,
            'job_categories'    => $job_categories
        ];

        return view('backend.employer.jobs.create', $view);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Requests\Backend\Employer\Job\CreateJobRequest $request)
    {

        $this->jobs->create($request);

        return redirect()
            ->route('admin.employer.jobs.index')
            ->withFlashSuccess('Successfully created the job');
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
    public function edit(Requests\Backend\Employer\Job\EditJobViewRequest $request, $id)
    {

        $job = $this->jobs->findOrThrowException($id);

        $job_categories = \DB::table('job_categories')->select(['id', 'name'])->get();
        $countries = \DB::table('countries')->select(['id', 'name'])->get();

        if ( $request->old('country_id') || ( $job && $job->country_id ) ) {
            $country_id = $request->old('country_id') ? $request->old('country_id') : $job->country_id;
            $states = \DB::table('states')->where('country_id', $country_id)->select(['id', 'name'])->get();
        } else {
            $states = \DB::table('states')->where('country_id', 222)->select(['id', 'name'])->get();
        }

        $view = [
            'job'                   => $job,
            'countries'             => $countries,
            'states'                => $states,
            'job_categories'        => $job_categories
        ];

        return view('backend.employer.jobs.edit', $view);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Requests\Backend\Employer\Job\UpdateJobRequest $request, $id)
    {
        $this->jobs->update($id,$request->all());

        return redirect()->route('admin.employer.jobs.index')->withFlashSuccess("The job was successfully updated.");
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

    /**
     * @param $id
     * @param $status
     * @param MarkJobRequest $request
     * @return mixed
     */
    public function mark($id, $status, MarkJobRequest $request) {
        $this->jobs->mark($id, $status);

        return redirect(route('admin.employer.jobs.index'))->withFlashSuccess('The job was successfully updated.');
    }

    public function publish($id, PublishJobRequest $request)
    {
        $this->jobs->publish($id);

        return redirect(route('admin.employer.jobs.index'))->withFlashSuccess('The job was successfully updated.');
    }

    public function hide($id, HideJobRequest $request)
    {
        $this->jobs->hide($id);

        return redirect(route('admin.employer.jobs.index'))->withFlashSuccess('The job was successfully updated.');
    }
}
