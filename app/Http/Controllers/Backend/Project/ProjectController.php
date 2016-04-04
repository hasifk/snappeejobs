<?php

namespace App\Http\Controllers\Backend\Project;

use App\Http\Requests\Backend\Employer\Project\ProjectCreateRequest;
use App\Http\Requests\Backend\Employer\Task\CreateTaskRequest;
use App\Models\Project\Project;
use App\Repositories\Backend\Project\EloquentProjectRepository;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ProjectController extends Controller
{

    /**
     * @var EloquentProjectRepository
     */
    private $projectRepository;

    public function __construct(EloquentProjectRepository $projectRepository)
    {

        $this->projectRepository = $projectRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $projects = $this->projectRepository->getProjects(10);

        $view = [
            'projects' => $projects
        ];

        return view('backend.projects.index', $view);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $members = $this->projectRepository->getEmployers();
        $job_listings = $this->projectRepository->getJobListings();

        $view = [
            'members' => $members,
            'job_listings' => $job_listings
        ];

        return view('backend.projects.create', $view);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProjectCreateRequest $request)
    {

        $this->projectRepository->createProject($request);

        return redirect()
            ->route('admin.projects.index')
            ->withFlashSuccess('Successfully created the Project');

    }

    /**
     * Display the specified resource.
     *
     * @param Requests\Backend\Employer\Project\ProjectViewRequest $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Requests\Backend\Employer\Project\ProjectViewRequest $request, $id)
    {

        $project = Project::find($id);

        $project_members = \DB::table('members_project')
            ->join('users', 'members_project.user_id', '=', 'users.id')
            ->where('members_project.project_id', $project->id)
            ->lists('users.name');

        $job_listings = \DB::table('job_listing_project')
            ->join('jobs', 'job_listing_project.job_id', '=', 'jobs.id')
            ->where('job_listing_project.project_id', $project->id)
            ->lists('jobs.title');

        $project_tasks = \DB::table('task_project')
            ->where('project_id', $id)
            ->select(['task_project.id', 'task_project.title'])
            ->get();

        $view = [
            'project'           => $project,
            'members'           => implode(' , ', $project_members),
            'job_listings'      => implode(' , ', $job_listings),
            'project_tasks'     => $project_tasks
        ];

        return view('backend.projects.show', $view);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $project = Project::findOrFail($id);
        $members = $this->projectRepository->getEmployers();
        $job_listings = $this->projectRepository->getJobListings();

        $project_members = \DB::table('members_project')
            ->where('project_id', $project->id)
            ->lists('user_id');

        $project_job_listings = \DB::table('job_listing_project')
            ->where('project_id', $project->id)
            ->lists('job_id');

        $view = [
            'project'                   => $project,
            'members'                   => $members,
            'job_listings'              => $job_listings,
            'project_members'           => $project_members,
            'project_job_listings'     => $project_job_listings
        ];

        return view('backend.projects.edit', $view);
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
        dd($request->all());
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
    
    public function assignTasks($id){

        $members = $this->projectRepository->getStaffForProject($id);

        $view = [
            'members'       => $members,
            'project_id'    => $id
        ];

        return view('backend.projects.assigntasks', $view);
    }

    public function storeTask(CreateTaskRequest $request, $project_id){

        $project = Project::findOrFail($project_id);

        $this->projectRepository->createTask($project, $request);

        return redirect()
            ->route('admin.projects.index')
            ->withFlashSuccess('Successfully created the Task');

    }
}
