<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon as Carbon;

class UserTableSeeder extends Seeder {

	public function run() {

		if(env('DB_DRIVER') == 'mysql')
			DB::statement('SET FOREIGN_KEY_CHECKS=0;');

		if(env('DB_DRIVER') == 'mysql')
			DB::table(config('auth.table'))->truncate();
		elseif(env('DB_DRIVER') == 'sqlite')
			DB::statement("DELETE FROM ".config('auth.table'));
		else //For PostgreSQL or anything else
			DB::statement("TRUNCATE TABLE ".config('auth.table')." CASCADE");

		//Add the master administrator, user id of 1
		$users = [
			[
				'name' => 'Admin Istrator',
				'email' => 'admin@admin.com',
				'password' => bcrypt('eeppans'),
				'confirmation_code' => md5(uniqid(mt_rand(), true)),
				'confirmed' => true,
                'employer_id'=>1,
                'country_id'        => 0,
                'state_id'          => 0,
				'created_at' => Carbon::now(),
				'updated_at' => Carbon::now()
			],
			[
				'name' => 'Silverbloom Technologies',
				'email' => 'info@silverbloom.com',
				'password' => bcrypt('asdasd'),
				'confirmation_code' => md5(uniqid(mt_rand(), true)),
				'confirmed' => true,
				'employer_id'=>2,
                'country_id'        => 222,
                'state_id'          => 3428,
				'created_at' => Carbon::now(),
				'updated_at' => Carbon::now()
			],
			[
				'name' => 'HR Silverbloom',
				'email' => 'hr@silverbloom.com',
				'password' => bcrypt('asdasd'),
				'confirmation_code' => md5(uniqid(mt_rand(), true)),
				'confirmed' => true,
                'employer_id'=>3,
                'country_id'        => 222,
                'state_id'          => 3428,
				'created_at' => Carbon::now(),
				'updated_at' => Carbon::now()
			],
			[
				'name' => 'Default User',
				'email' => 'user@user.com',
				'password' => bcrypt('asdasd'),
				'confirmation_code' => md5(uniqid(mt_rand(), true)),
				'confirmed' => true,
                'employer_id'=>4,
                'country_id'        => 222,
                'state_id'          => 3428,
				'created_at' => Carbon::now(),
				'updated_at' => Carbon::now()
			],[
				'name' => 'Mark',
				'email' => 'mark@facebook.com',
				'password' => bcrypt('asdasd'),
				'confirmation_code' => md5(uniqid(mt_rand(), true)),
				'confirmed' => true,
                'employer_id'=>5,
                'country_id'        => 0,
                'state_id'          => 0,
				'created_at' => Carbon::now(),
				'updated_at' => Carbon::now()
			],
		];

		DB::table(config('auth.table'))->insert($users);

		if(env('DB_DRIVER') == 'mysql')
			DB::statement('SET FOREIGN_KEY_CHECKS=1;');
	}
}
