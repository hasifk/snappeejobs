<?php

namespace App\Http\Requests\Backend\Employer\Staff;

use App\Http\Requests\Request;

class EditEmployerRequest extends Request
{

    private $userId;
    private $employerId;
    private $staffs;
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return access()->can('edit-employer-staff');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        $this->userId = $this->segment(4);

        $rules = [
            'name' 		        => 'required|max:255',
            'email' 	        => 'required|email|max:255|unique:users,email,'.$this->userId
        ];

        $this->employerId = \DB::table('staff_employer')->where('user_id', $this->userId)->value('employer_id');

        if ( $this->employerId ) {
            $this->staffs = \DB::table('staff_employer')->where('employer_id', $this->employerId)->lists('user_id');

            if ( $this->staffs ) {
                if ( ! in_array($this->userId, $this->staffs) ) {
                    $rules['user'] = 'required';
                }
            }
        } else {
            $rules['user'] = 'required';
        }

        if ( $this->request->get('assignees_roles') ) {
            foreach ($this->request->get('assignees_roles') as $key => $item) {
                $rules['assignees_roles.'.$key] = 'required|in:'.config('access.employers.default_role').','
                    .config('access.employer_staff.default_role');
            }
        } else {
            $rules['assignees_roles'] = 'required';
        }

        return $rules;
    }

    public function messages()
    {

        $messages = [
            'assignees_roles.required' => 'You should at least select one role for the user'
        ];
        if ( $this->request->get('assignees_roles') ) {
            foreach ($this->request->get('assignees_roles') as $key => $item) {
                $messages['assignees_roles.'.$key.'.in'] = 'The assigned role : '.$key.' must be either employer or
            employer staff type';
            }
        }

        if ( $this->employerId ) {
            if ( $this->staffs ) {
                if ( ! in_array($this->userId, $this->staffs) ) {
                    $messages['user.required'] = 'You are not authorized to edit this user';
                }
            }
        } else {
            $messages['user.required'] = 'You are not authorized to edit this user';
        }

        return $messages;
    }

}
