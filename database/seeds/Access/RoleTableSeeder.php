<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon as Carbon;

class RoleTableSeeder extends Seeder {

	public function run() {

		if(env('DB_DRIVER') == 'mysql')
			DB::statement('SET FOREIGN_KEY_CHECKS=0;');

		if(env('DB_DRIVER') == 'mysql')
			DB::table(config('access.roles_table'))->truncate();
		elseif(env('DB_DRIVER') == 'sqlite')
			DB::statement("DELETE FROM ".config('access.roles_table'));
		else //For PostgreSQL or anything else
			DB::statement("TRUNCATE TABLE ".config('access.roles_table')." CASCADE");

		//Create admin role, id of 1
		$role_model = config('access.role');
		$admin = new $role_model;
		$admin->name = 'Administrator';
		$admin->all = true;
		$admin->sort = 1;
		$admin->created_at = Carbon::now();
		$admin->updated_at = Carbon::now();
		$admin->save();

		//Create Employer role, id of 2
		$role_model = config('access.role');
		$admin = new $role_model;
		$admin->name = 'Employer';
		$admin->all = false;
		$admin->sort = 2;
		$admin->created_at = Carbon::now();
		$admin->updated_at = Carbon::now();
		$admin->save();

		// Employer Staff - id = 4
		$role_model = config('access.role');
		$employer_staff = new $role_model;
		$employer_staff->name = 'Employer Staff';
		$employer_staff->sort = 3;
		$employer_staff->created_at = Carbon::now();
		$employer_staff->updated_at = Carbon::now();
		$employer_staff->save();

		// Normal User - id = 3
		$role_model = config('access.role');
		$user = new $role_model;
		$user->name = 'User';
		$user->sort = 4;
		$user->created_at = Carbon::now();
		$user->updated_at = Carbon::now();
		$user->save();

		if(env('DB_DRIVER') == 'mysql')
			DB::statement('SET FOREIGN_KEY_CHECKS=1;');
	}
}
