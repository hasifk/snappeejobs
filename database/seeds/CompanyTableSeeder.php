<?php

use Illuminate\Database\Seeder;


class CompanyTableSeeder extends Seeder
{
    public function run()
    {

        $faker = Faker\Factory::create();

        $companies = [
            [
                'employer_id'       => 2,
                'title'             => 'SilverBloom',
                'url_slug'          => 'silverbloom',
                'size'              => 'small',
                'description'       => 'But before this autonomous future arrives, Tesla has got to start stemming its huge losses. And given that right now most of us have a better chance of riding one of his rockets than buying one of his cars Elon Musk knows he needs to start making something affordable. "We need to make a car that most people can afford in order to have a substantial impact," he admitted. We have arrived after driving from Las Vegas in a Model S, getting some insight into the electric cars progress towards that autonomous future its creator believes is just around the corner. On the freeway I switch on Autopilot mode so that the car steers itself at a constant speed, unless it gets too close to a vehicle in front, and it even changes lanes once I flip the indicator.',
                'what_it_does'      => "We have arrived after driving from Las Vegas in a Model S, getting some insight into the electric car's progress towards that autonomous future its creator believes is just around the corner. On the freeway I switch on Autopilot mode so that the car steers itself at a constant speed, unless it gets too close to a vehicle in front, and it even changes lanes once I flip the indicator.",
                'office_life'       => "But that must surely be a long way off, I stutter. The Tesla founder shrugs his shoulders and says not that long. A couple of years. Now, just imagine the technological advances and regulatory changes that would be needed to allow a car to drive on its own 3,000 miles, only stopping to plug itself into a Tesla Supercharger. Its completely bonkers to think this could be achieved some time in the next couple of years.",
                'country_id'        => 38,
                'state_id'          => 605,
                'default_photo_id'  => 1,
                'logo'              => 'http://www.heinz.com/media/downloads/view/HeinzLogo.jpg',
                'likes'             => 3,
                'created_at'        => \Carbon\Carbon::now(),
                'updated_at'        => \Carbon\Carbon::now()
            ],
            [
                'employer_id'       => 5,
                'title'             => 'Facebook',
                'url_slug'          => 'facebook',
                'size'              => 'big',
                'description'       => "We have arrived after driving from Las Vegas in a Model S, getting some insight into the electric car's progress towards that autonomous future its creator believes is just around the corner. On the freeway I switch on Autopilot mode so that the car steers itself at a constant speed, unless it gets too close to a vehicle in front, and it even changes lanes once I flip the indicator. We have arrived after driving from Las Vegas in a Model S, getting some insight into the electric car's progress towards that autonomous future its creator believes is just around the corner. On the freeway I switch on Autopilot mode so that the car steers itself at a constant speed, unless it gets too close to a vehicle in front, and it even changes lanes once I flip the indicator.",
                'what_it_does'      => 'But before this autonomous future arrives, Tesla has got to start stemming its huge losses. And given that right now most of us have a better chance of riding one of his rockets than buying one of his cars Elon Musk knows he needs to start making something affordable. "We need to make a car that most people can afford in order to have a substantial impact," he admitted.',
                'office_life'       => "But that must surely be a long way off, I stutter. The Tesla founder shrugs his shoulders and says not that long. A couple of years. Now, just imagine the technological advances and regulatory changes that would be needed to allow a car to drive on its own 3,000 miles, only stopping to plug itself into a Tesla Supercharger. Its completely bonkers to think this could be achieved some time in the next couple of years.",
                'country_id'        => 16,
                'state_id'          => 290,
                'default_photo_id'  => 2,
                'logo'              => 'https://www.facebookbrand.com/img/fb-art.jpg',
                'likes'             => 8,
                'created_at'        => \Carbon\Carbon::now(),
                'updated_at'        => \Carbon\Carbon::now()
            ]
        ];

        DB::table('companies')->insert($companies);

        $photos = [
            [
                'id'                => 1,
                'company_id'        => 1,
                'path'              => 'http://officesnapshots.com/wp-content/uploads/2012/09/',
                'filename'          => 's7',
                'extension'         => '.jpg',
                'created_at'        => \Carbon\Carbon::now(),
                'updated_at'        => \Carbon\Carbon::now()
            ],
            [
                'id'                => 2,
                'company_id'        => 2,
                'path'              => 'https://vegivo.files.wordpress.com/2011/04/',
                'filename'          => 'drvsf_photo_005_reflectionsstudio',
                'extension'         => '.jpg',
                'created_at'        => \Carbon\Carbon::now(),
                'updated_at'        => \Carbon\Carbon::now()
            ]
        ];

        DB::table('photo_company')->insert($photos);

        $people = [
            [
                'id'                => 1,
                'company_id'        => 1,
                'name'              => $faker->name,
                'designation'       => $faker->name,
                'about_me'          => $faker->text(150),
                'path'              => 'http://dummyimage.com/320x480/000/',
                'filename'          => 'f23',
                'extension'         => '.jpg',
                'testimonial'       => $faker->text(60),
                'created_at'        => \Carbon\Carbon::now(),
                'updated_at'        => \Carbon\Carbon::now()
            ],
            [
                'id'                => 2,
                'company_id'        => 1,
                'name'              => $faker->name,
                'designation'       => $faker->name,
                'about_me'          => $faker->text(150),
                'path'              => 'http://dummyimage.com/320x480/000/',
                'filename'          => 'f23',
                'extension'         => '.jpg',
                'testimonial'       => $faker->text(60),
                'created_at'        => \Carbon\Carbon::now(),
                'updated_at'        => \Carbon\Carbon::now()
            ],
            [
                'id'                => 3,
                'company_id'        => 1,
                'name'              => $faker->name,
                'designation'       => $faker->name,
                'about_me'          => $faker->text(150),
                'path'              => 'http://dummyimage.com/320x480/000/',
                'filename'          => 'f23',
                'extension'         => '.jpg',
                'testimonial'       => $faker->text(60),
                'created_at'        => \Carbon\Carbon::now(),
                'updated_at'        => \Carbon\Carbon::now()
            ],
            [
                'id'                => 5,
                'company_id'        => 2,
                'name'              => $faker->name,
                'designation'       => $faker->name,
                'about_me'          => $faker->text(150),
                'path'              => 'http://dummyimage.com/320x480/000/',
                'filename'          => 'f23',
                'extension'         => '.jpg',
                'testimonial'       => $faker->text(60),
                'created_at'        => \Carbon\Carbon::now(),
                'updated_at'        => \Carbon\Carbon::now()
            ],
            [
                'id'                => 6,
                'company_id'        => 2,
                'name'              => $faker->name,
                'designation'       => $faker->name,
                'about_me'          => $faker->text(150),
                'path'              => 'http://dummyimage.com/320x480/000/',
                'filename'          => 'f23',
                'extension'         => '.jpg',
                'testimonial'       => $faker->text(60),
                'created_at'        => \Carbon\Carbon::now(),
                'updated_at'        => \Carbon\Carbon::now()
            ],
            [
                'id'                => 7,
                'company_id'        => 2,
                'name'              => $faker->name,
                'designation'       => $faker->name,
                'about_me'          => $faker->text(150),
                'path'              => 'http://dummyimage.com/320x480/000/',
                'filename'          => 'f23',
                'extension'         => '.jpg',
                'testimonial'       => $faker->text(60),
                'created_at'        => \Carbon\Carbon::now(),
                'updated_at'        => \Carbon\Carbon::now()
            ]
        ];

        DB::table('people_company')->insert($people);


    }
}
