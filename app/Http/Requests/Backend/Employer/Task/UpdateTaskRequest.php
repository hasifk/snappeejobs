<?php

namespace App\Http\Requests\Backend\Employer\Task;

use App\Exceptions\Backend\Project\ProjectDoesNotBelongToUser;
use App\Http\Requests\Request;

class UpdateTaskRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return access()->can('edit-task');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        $task_id = $this->segment(3);

        $task_belongs_to_user = \DB::table('task_project')
            ->where('id', $task_id)
            ->where('employer_id', auth()->user()->employer_id)
            ->count();

        if ( ! $task_belongs_to_user ) {
            $this->throwException('This task does not belong to you.');
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
