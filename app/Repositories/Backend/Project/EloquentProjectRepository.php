<?php

namespace App\Repositories\Backend\Project;


use App\Models\Project\Project;
use App\Models\Project\ProjectJobListing;
use App\Models\Project\ProjectMember;
use App\Models\Task\Task;
use App\Models\Task\TaskMember;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;

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

    public function getStaffForProject($project_id){
        return \DB::table('members_project')
            ->join('users', 'members_project.user_id', '=', 'users.id')
            ->where('members_project.project_id', '=', $project_id)
            ->select(['users.id', 'users.name'])
            ->get();
    }

    public function getJobListings(){
        $company_id = \DB::table('companies')->where('employer_id', $this->user->user()->employer_id)->value('id');
        return \DB::table('jobs')
            ->where('jobs.company_id', '=', $company_id)
            ->where('jobs.status', true)
            ->where('jobs.published', true)
            ->select(['jobs.id', 'jobs.title'])
            ->get();
    }

    public function getProjects($per_page, $order_by = 'projects.id', $sort = 'asc'){
        $projects = Project::where('employer_id', $this->user->user()->employer_id)
                ->with(['members', 'job_listings'])
                ->orderBy($order_by, $sort)
                ->paginate($per_page);
        return $projects;
    }

    public function createProject(Request $request){

        $project = $this->createProjectStub($request);

        $this->flushAndCreateProjectMembers($project, $request);
        $this->flushAndCreateProjectJobListings($project, $request);

        return $project;
    }

    private function createProjectStub(Request $request){

        $project = Project::create([
            'title'         => $request->get('title'),
            'created_by'    => $this->user->user()->id,
            'employer_id'   => $this->user->user()->employer_id
        ]);

        return $project;
    }

    private function flushAndCreateProjectMembers(Project $project, Request $request) {
        // Delete all the members
        ProjectMember::where('project_id', $project->id)->delete();

        // Now reassign available members
        foreach ($request->get('members') as $member) {
            ProjectMember::create([
                'project_id'    => $project->id,
                'user_id'       => $member
            ]);
        }

        return;
    }

    private function flushAndCreateProjectJobListings(Project $project, Request $request) {
        // Delete all the job listings
        ProjectJobListing::where('project_id', $project->id)->delete();

        // Now reassign available job listings
        foreach ($request->get('job_listings') as $job_listing) {
            ProjectJobListing::create([
                'project_id'    => $project->id,
                'job_id'        => $job_listing
            ]);
        }

        return;
    }

    public function createTask(Project $project, Request $request) {

        $task = Task::create([
            'project_id'        => $project->id,
            'title'             => $request->get('title'),
            'created_by'    => $this->user->user()->id,
            'employer_id'   => $this->user->user()->employer_id
        ]);

        foreach ($request->get('members') as $member) {
            TaskMember::create([
                'task_id'       => $task->id,
                'user_id'       => $member
            ]);
        }

        return $task;

    }

}
