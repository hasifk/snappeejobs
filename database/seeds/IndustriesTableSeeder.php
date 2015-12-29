<?php

use Illuminate\Database\Seeder;

class IndustriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $industries = [
            "Business & Strategy","Creative & Design","Customer Service","Editorial","Education","Engineering",
            "Finance & Data","Fundraising & Development","HR & Recruiting","Legal","Marketing & PR","Operations",
            "Project & Product Management","Research & Medicine","Sales","Social Media & Community"
        ];

        foreach ($industries as $industry) {
            DB::table( 'industries' )->insert([
                'name'          => $industry,
                'created_at'    => \Carbon\Carbon::now(),
                'updated_at'    => \Carbon\Carbon::now(),
            ]);
        }

    }
}
