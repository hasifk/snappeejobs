<?php

use Illuminate\Database\Seeder;

class JobCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $job_categories = [
            "Business & Strategy","Creative & Design","Customer Service","Editorial","Education","Engineering",
            "Finance & Data","Fundraising & Development","HR & Recruiting","Legal","Marketing & PR","Operations",
            "Project & Product Management","Research & Medicine","Sales","Social Media & Community"
        ];

        foreach ($job_categories as $job_category) {
            DB::table( 'job_categories' )->insert([
                'name'          => $job_category,
                'created_at'    => \Carbon\Carbon::now(),
                'updated_at'    => \Carbon\Carbon::now(),
            ]);
        }
    }
}
