<?php

namespace App\Http\Controllers\Backend\Project;

use App\Http\Requests\Backend\Employer\Task\EditTaskViewRequest;
use App\Http\Requests\Backend\Employer\Project\ProjectCreateRequest;
use App\Http\Requests\Backend\Employer\Task\CreateTaskRequest;
use App\Models\Project\Project;
use App\Models\Task\Task;
use App\Repositories\Backend\Logs\LogsActivitysRepository;
use App\Repositories\Backend\Project\EloquentProjectRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Activity;
class ProjectController extends Controller
{

    /**
     * @var EloquentProjectRepository
     */
    private $projectRepository;
    private $userLogs;
    public function __construct(EloquentProjectRepository $projectRepository,LogsActivitysRepository $userLogs)
    {

        $this->projectRepository = $projectRepository;
        $this->userLogs = $userLogs;
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
        $array['type'] = 'Project';
        $array['heading']='Name:'.$request->title;
        if($this->projectRepository->createProject($request))
        {
            $array['event'] = 'created';

            $name = $this->userLogs->getActivityDescriptionForEvent($array);
            Activity::log($name);
        }

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
            ->whereNull('task_project.deleted_at')
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
     * @param Requests\Backend\Employer\Project\ProjectEditViewRequest $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Requests\Backend\Employer\Project\ProjectEditViewRequest $request, $id)
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
    public function update(Requests\Backend\Employer\Project\ProjectEditRequest $request, $id)
    {

        $project = Project::findOrFail($id);
        $array['type'] = 'Project';
        $array['heading']='Name:'.$project->title;
       if($this->projectRepository->updateProject($project, $request))
       {
           $array['event'] = 'updated';
           $name = $this->userLogs->getActivityDescriptionForEvent($array);
           Activity::log($name);
       }

        return redirect()
            ->route('admin.projects.index')
            ->withFlashSuccess('Successfully updated the Project');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Requests\Backend\Employer\Project\DeleteProjectRequest $request, $id)
    {
        $project = Project::find($id);
        $array['type'] = 'Project';
        $array['heading']='Name:'.$project->title;
        if($this->projectRepository->deleteProject($project))
        {
            $array['event'] = 'deleted';
            $name = $this->userLogs->getActivityDescriptionForEvent($array);
            Activity::log($name);
        }

        return redirect()
            ->route('admin.projects.index')
            ->withFlashSuccess('Successfully deleted the Project');
    }
    
    public function assignTasks($id){

        $members = $this->projectRepository->getStaffForProject($id);

        $tasks = $this->projectRepository->getTasks($id);

        $view = [
            'members'       => $members,
            'tasks'       => $tasks,
            'project_id'    => $id
        ];

        return view('backend.projects.assigntasks', $view);
    }

    public function storeTask(CreateTaskRequest $request, $project_id){

        $project = Project::findOrFail($project_id);
        $array['type'] = 'Task';
        $array['heading']='Name:'.$request->title;
        if($this->projectRepository->createTask($project, $request))
        {
            $array['event'] = 'created';
            $name = $this->userLogs->getActivityDescriptionForEvent($array);
            Activity::log($name);
        }

        return redirect()
            ->route('admin.projects.index')
            ->withFlashSuccess('Successfully created the Task');

    }
    
    public function editTask(EditTaskViewRequest $request, $id){

        $task = Task::findOrFail($id);
        $project_members = \DB::table('members_project')
            ->join('users', 'users.id', '=', 'members_project.user_id')
            ->where('members_project.project_id', $task->project_id)
            ->select(['users.id', 'users.name'])
            ->get();

        $project_members_array = \DB::table('members_project')
            ->join('users', 'users.id', '=', 'members_project.user_id')
            ->where('members_project.project_id', $task->project_id)->lists('users.id');

        $view = [ 'task'=> $task, 'project_members' => $project_members, 'project_members_array' => $project_members_array ];

        return view('backend.projects.edittasks', $view);

    }

    public function showTask(Requests\Backend\Employer\Task\ShowTaskViewRequest $request, $id){

        Task::where('id',$id)->update(['read_at' => Carbon::now()]);
        $task = Task::find($id);
        $view = [
            'task' => $task
        ];

        return view('backend.projects.showtask', $view);

    }

    public function updateTask(Requests\Backend\Employer\Task\UpdateTaskRequest $request, $id){

        $task = Task::find($id);
        $array['type'] = 'Task';
        $array['heading']='Name:'.$task->title;
        if($this->projectRepository->updateTask($task, $request))
        {
            $array['event'] = 'updated';
            $name = $this->userLogs->getActivityDescriptionForEvent($array);
            Activity::log($name);
        }

        return redirect()
            ->route('admin.projects.showtask', $id)
            ->withFlashSuccess('Successfully updated the Task');

    }

    public function deleteTask(Requests\Backend\Employer\Task\DeleteTaskRequest $request, $id){

        $task = Task::find($id);

        $project_id = \DB::table('task_project')->where('id', $id)->value('project_id');
        $array['type'] = 'Task';
        $array['heading']='Name:'.$task->title;
        if($this->projectRepository->deleteTask($task, $request))
        {
            $array['event'] = 'deleted';
            $name = $this->userLogs->getActivityDescriptionForEvent($array);
            Activity::log($name);
        }

        return redirect()
            ->route('admin.projects.show', $project_id)
            ->withFlashSuccess('Successfully deleted the Task');

    }
    
}
