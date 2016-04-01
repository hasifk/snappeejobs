<?php

use Illuminate\Database\Seeder;


class CompanyTableSeeder extends Seeder
{
    public function run()
    {

        \DB::statement(
           "
            INSERT INTO `companies` (`id`, `employer_id`, `title`, `url_slug`, `size`, `description`, `what_it_does`, `office_life`, `country_id`, `state_id`, `default_photo_id`, `logo`, `followers`, `created_at`, `updated_at`) VALUES
            (1, 2, 'Silverbloom Technologies', 'silverbloom-technologies', 'big', 'asd\r\nasd\r\nsa\r\ndsa\r\ndsd', 'asd\r\nasd\r\nsa\r\n\r\nsad\r\nsd\r\ndad\r\n', 'asd\r\nas\r\nd\r\nasd\r\nsad\r\nasd', 222, 3428, 0, '', 0, '2016-02-11 00:17:47', '2016-02-11 00:17:47');
            "
        );

        \DB::statement(
           "
            INSERT INTO `industry_company` (`id`, `company_id`, `industry_id`, `created_at`, `updated_at`) VALUES
            (1, 1, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
            (2, 1, 2, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
            (3, 1, 3, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
            "
        );

        \DB::statement(
           "
            INSERT INTO `jobs` (`id`, `company_id`, `title`, `title_url_slug`, `level`, `country_id`, `state_id`, `likes`, `description`, `status`, `published`, `created_at`, `updated_at`, `deleted_at`) VALUES
            (1, 1, 'Salesforce Developer', 'salesforce-developer', 'mid', 222, 3428, 0, 'asda<br>sdsa<br>dasd', 1, 1, '2016-02-11 00:18:27', '2016-02-11 00:18:30', NULL);
            "
        );

        \DB::statement(
           "
            INSERT INTO `job_prerequisites` (`id`, `job_id`, `content`, `created_at`, `updated_at`) VALUES
            (1, 1, 'azazaz', '2016-02-11 00:18:27', '2016-02-11 00:18:27'),
            (2, 1, 'aaaaaaaaa', '2016-02-11 00:18:27', '2016-02-11 00:18:27'),
            (3, 1, 'qqqq', '2016-02-11 00:18:27', '2016-02-11 00:18:27');
            "
        );

        \DB::statement(
           "
            INSERT INTO `job_skills` (`id`, `job_id`, `skill_id`, `created_at`, `updated_at`) VALUES
            (1, 1, 222, '2016-02-11 00:18:27', '2016-02-11 00:18:27');
            "
        );

        \DB::statement(
           "
            INSERT INTO `category_preferences_jobs` (`id`, `job_id`, `job_category_id`, `created_at`, `updated_at`) VALUES
            (1, 1, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
            (2, 1, 2, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
            (3, 1, 3, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
            "
        );

        return;

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
                'followers'             => 3,
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
                'followers'             => 8,
                'created_at'        => \Carbon\Carbon::now(),
                'updated_at'        => \Carbon\Carbon::now()
            ]
        ];

        DB::table('companies')->insert($companies);

        $photos = [
            [
                'id'                => 1,
                'company_id'        => 1,
                'path'              => 'http://dummyimage.com/480x260/888/000/',
                'filename'          => 'f23',
                'extension'         => '.jpg',
                'created_at'        => \Carbon\Carbon::now(),
                'updated_at'        => \Carbon\Carbon::now()
            ],
            [
                'id'                => 2,
                'company_id'        => 2,
                'path'              => 'http://dummyimage.com/480x260/888/000/',
                'filename'          => 'f23',
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
                'path'              => 'http://dummyimage.com/320x480/888/000/',
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
                'path'              => 'http://dummyimage.com/320x480/888/000/',
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
                'path'              => 'http://dummyimage.com/320x480/888/000/',
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
                'path'              => 'http://dummyimage.com/320x480/888/000/',
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
                'path'              => 'http://dummyimage.com/320x480/888/000/',
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
                'path'              => 'http://dummyimage.com/320x480/888/000/',
                'filename'          => 'f23',
                'extension'         => '.jpg',
                'testimonial'       => $faker->text(60),
                'created_at'        => \Carbon\Carbon::now(),
                'updated_at'        => \Carbon\Carbon::now()
            ]
        ];

        DB::table('people_company')->insert($people);

        $socialMedia = [
            [
                'id'                => 1,
                'company_id'        => 1,
                'url'               => 'https://twitter.com/silverbloomtech',
                'created_at'        => \Carbon\Carbon::now(),
                'updated_at'        => \Carbon\Carbon::now()
            ],
            [
                'id'                => 2,
                'company_id'        => 1,
                'url'               => 'https://www.facebook.com/silverbloomtech',
                'created_at'        => \Carbon\Carbon::now(),
                'updated_at'        => \Carbon\Carbon::now()
            ],
            [
                'id'                => 3,
                'company_id'        => 2,
                'url'               => 'https://twitter.com/silverbloomtech',
                'created_at'        => \Carbon\Carbon::now(),
                'updated_at'        => \Carbon\Carbon::now()
            ],
            [
                'id'                => 4,
                'company_id'        => 2,
                'url'               => 'https://www.facebook.com/silverbloomtech',
                'created_at'        => \Carbon\Carbon::now(),
                'updated_at'        => \Carbon\Carbon::now()
            ]
        ];

        DB::table('socialmediainfo_company')->insert($socialMedia);



    }
}
