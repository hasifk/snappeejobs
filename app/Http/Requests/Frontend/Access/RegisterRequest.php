<?php namespace App\Http\Requests\Frontend\Access;

use App\Http\Requests\Request;

/**
 * Class RegisterRequest
 * @package App\Http\Requests\Frontend\Access
 */
class RegisterRequest extends Request {

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return [
			'name' 		=> 'required|max:255',
			'email' 	=> 'required|email|max:255|unique:users',
			'password'  => 'required|confirmed|min:6',
			'gender'	=> 'required|in:male,female',
			'dob'		=> 'required|date',
			'country_id'=> 'required',
			'state_id'  => 'required',
		];
	}

	public function messages(){
		return [
			'country_id.required'           => 'Country is required',
			'state_id.required'             => 'State is required'
		];
	}
}
