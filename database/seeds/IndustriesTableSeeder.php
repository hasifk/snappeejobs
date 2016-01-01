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
            "Advertising and Agencies","Arts and Music","Client Services","Consumer","Education",
            "Entertainment &amp; Gaming","Fashion and Beauty","Finance","Food","Government",
            "Healthcare","Law","Media","Real Estate &amp; Construction","Social Good",
            "Social Media","Tech","Telecom","Travel and Hospitality"
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
