<?php

namespace App\Http\Requests\Backend\Employer\Project;

use App\Exceptions\Backend\Project\ProjectDoesNotBelongToUser;
use App\Http\Requests\Request;

class ProjectEditRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return access()->can('edit-project');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        $id = $this->segment(3);

        $project_belongs_to_user = \DB::table('projects')->where('employer_id', auth()->user()->employer_id)->where('id', $id)->count();

        if ( ! $project_belongs_to_user ) {
            $this->throwException('This project does not belong to your company.');
        }

        // Check if there are any members removed , if so, check if any of those removed members belong to any tasks
        // in the project

        $members = \DB::table('members_project')->where('project_id', $id)->lists('user_id');
        $new_members = $this->get('members');

        $deleted_members = array_diff($members, $new_members);

        if ( $deleted_members ) {
            // Get the users who has tasks in this project
            $user_ids = \DB::table('task_project')
                ->join('staff_task', 'task_project.id', '=', 'staff_task.task_id')
                ->where('task_project.project_id', $id)
                ->distinct()
                ->lists('staff_task.user_id');

            if ( count(array_diff($user_ids, $deleted_members)) != count($user_ids) ) {
                $this->throwException('you cannot delete some of the members, because they are assigned to some of the tasks in this project');
            }

        }

        return [
            //
        ];
    }

    private function throwException($message){
        $exception = new ProjectDoesNotBelongToUser();
        $exception->setValidationErrors($message);

        throw $exception;
    }

}
