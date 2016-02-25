<?php

namespace App\Http\Requests\Backend\Employer\Staff;

use App\Http\Requests\Request;

class CreateEmployerRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return access()->can('create-employer-staff');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        $rules = [
            'name' 		        => 'required|max:255',
            'email' 	        => 'required|email|max:255|unique:users',
            'password'          => 'required|confirmed|min:6',
            'gender'            => 'required|in:male,female',
            'dob'               => 'required|date',
        ];

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

        return $messages;
    }
}
