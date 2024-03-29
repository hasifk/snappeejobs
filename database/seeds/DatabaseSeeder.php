<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Model::unguard();

		if(env('DB_DRIVER')=='mysql')
			DB::statement('SET FOREIGN_KEY_CHECKS=0;');

		$this->call(AccessTableSeeder::class);
		$this->call(GeneralSeeder::class);
		$this->call(IndustriesTableSeeder::class);
		$this->call(JobCategoriesTableSeeder::class);
		$this->call(SkillsTableSeeder::class);
		$this->call(CompanyTableSeeder::class);
		$this->call(JobApplicationStatusTableSeeder::class);
		$this->call(CustomTableSeeder::class);
		$this->call(CmsTableSeeder::class);
		$this->call(BlogsCategoryTableSeeder::class);
        $this->call(BlogsSubCatsTableSeeder::class);

		if(env('DB_DRIVER')=='mysql')
			DB::statement('SET FOREIGN_KEY_CHECKS=1;');

		Model::reguard();
	}
}
