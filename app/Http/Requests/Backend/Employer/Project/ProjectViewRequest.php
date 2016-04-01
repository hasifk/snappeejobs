<?php

namespace App\Http\Requests\Backend\Employer\Project;

use App\Exceptions\Backend\Project\ProjectDoesNotBelongToUser;
use App\Http\Requests\Request;

class ProjectViewRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return access()->can('show-project');
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

        return [];
    }

    private function throwException($message){
        $exception = new ProjectDoesNotBelongToUser();
        $exception->setValidationErrors($message);

        throw $exception;
    }

}
