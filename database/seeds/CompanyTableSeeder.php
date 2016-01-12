<?php

use Illuminate\Database\Seeder;


class CompanyTableSeeder extends Seeder
{
    public function run()
    {

        $faker = Faker\Factory::create();

        $companyLimit = 5;

        /*for($companyCount = 0; $companyCount < $companyLimit; $companyCount++){

            DB::table('companies')->insert([
                'employer_id'       => $faker->numberBetween(0,100),
                'title'             => $faker->name,
                'url_slug'          => str_slug($faker->name,'-'),
                'size'              => $faker->randomElement(['small','medium','big']),
                'description'       => $faker->paragraph(3),
                'what_it_does'      => $faker->paragraph(3),
                'office_life'       => $faker->paragraph(3),
                'country_id'        => 7,
                'state_id'          => 7,
                'default_photo_id'  => $companyCount+1,
                'logo'              => $faker->imageUrl(120,80),
                'likes'             => $faker->numberBetween(1,10),
                'created_at'        => \Carbon\Carbon::now(),
                'updated_at'        => \Carbon\Carbon::now(),
            ]);

        }*/

        /*$companies = [

        ];*/
    }
}
