<?php

use Illuminate\Database\Seeder;

class BlogsSubCatsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sub_categories = [

            [   'blog_category_id'=>1,
                'name'       => 'Getting Started',
                'created_at'    => \Carbon\Carbon::now(),
                'updated_at'    => \Carbon\Carbon::now()
            ],
            [   'blog_category_id'=>1,
                'name'       => 'Getting Ahead ',
                'created_at'    => \Carbon\Carbon::now(),
                'updated_at'    => \Carbon\Carbon::now()
            ],
            [   'blog_category_id'=>1,
                'name'       => 'Work Relationships ',
                'created_at'    => \Carbon\Carbon::now(),
                'updated_at'    => \Carbon\Carbon::now()
            ],
            [   'blog_category_id'=>1,
                'name'       => 'Changing Jobs ',
                'created_at'    => \Carbon\Carbon::now(),
                'updated_at'    => \Carbon\Carbon::now()
            ],
            [   'blog_category_id'=>1,
                'name'       => 'Work-Life Balance',
                'created_at'    => \Carbon\Carbon::now(),
                'updated_at'    => \Carbon\Carbon::now()
            ],
            [
                'blog_category_id'=>1,
                'name'       => 'Working Abroad',
                'created_at'    => \Carbon\Carbon::now(),
                'updated_at'    => \Carbon\Carbon::now()
            ],
            [
                'blog_category_id'=>1,
                'name'       => 'Career Videos',
                'created_at'    => \Carbon\Carbon::now(),
                'updated_at'    => \Carbon\Carbon::now()
            ],
            [
                'blog_category_id'=>2,
                'name'       => 'Finding a Job',
                'created_at'    => \Carbon\Carbon::now(),
                'updated_at'    => \Carbon\Carbon::now()
            ],
            [
                'blog_category_id'=>2,
                'name'       => 'Resumes & Cover Letters',
                'created_at'    => \Carbon\Carbon::now(),
                'updated_at'    => \Carbon\Carbon::now()
            ],
            [
                'blog_category_id'=>2,
                'name'       => 'Career Videos',
                'created_at'    => \Carbon\Carbon::now(),
                'updated_at'    => \Carbon\Carbon::now()
            ],
            [
                'blog_category_id'=>2,
                'name'       => 'Interviewing for a Job',
                'created_at'    => \Carbon\Carbon::now(),
                'updated_at'    => \Carbon\Carbon::now()
            ],
            [
                'blog_category_id'=>2,
                'name'       => 'Networking',
                'created_at'    => \Carbon\Carbon::now(),
                'updated_at'    => \Carbon\Carbon::now()
            ],
            [
                'blog_category_id'=>2,
                'name'       => 'Jobs of the Week',
                'created_at'    => \Carbon\Carbon::now(),
                'updated_at'    => \Carbon\Carbon::now()
            ],
            [
                'blog_category_id'=>2,
                'name'       => 'Jobs Search Videos',
                'created_at'    => \Carbon\Carbon::now(),
                'updated_at'    => \Carbon\Carbon::now()
            ],

            [
                'blog_category_id'=>3,
                'name'       => 'Finding Your Passion',
                'created_at'    => \Carbon\Carbon::now(),
                'updated_at'    => \Carbon\Carbon::now()
            ],
            [
                'blog_category_id'=>3,
                'name'       => 'Exploring Career Paths',
                'created_at'    => \Carbon\Carbon::now(),
                'updated_at'    => \Carbon\Carbon::now()
            ],
            [
                'blog_category_id'=>3,
                'name'       => 'Career Changes',
                'created_at'    => \Carbon\Carbon::now(),
                'updated_at'    => \Carbon\Carbon::now()
            ],
            [
                'blog_category_id'=>3,
                'name'       => 'Grad School',
                'created_at'    => \Carbon\Carbon::now(),
                'updated_at'    => \Carbon\Carbon::now()
            ],
            [
                'blog_category_id'=>4,
                'name'       => 'Hiring',
                'created_at'    => \Carbon\Carbon::now(),
                'updated_at'    => \Carbon\Carbon::now()
            ],
            [
                'blog_category_id'=>4,
                'name'       => 'Conflict Resolution',
                'created_at'    => \Carbon\Carbon::now(),
                'updated_at'    => \Carbon\Carbon::now()
            ],
            [
                'blog_category_id'=>4,
                'name'       => 'Management Style',
                'created_at'    => \Carbon\Carbon::now(),
                'updated_at'    => \Carbon\Carbon::now()
            ],
            [
                'blog_category_id'=>4,
                'name'       => 'Team Culture',
                'created_at'    => \Carbon\Carbon::now(),
                'updated_at'    => \Carbon\Carbon::now()
            ],
            [
                'blog_category_id'=>5,
                'name'       => 'Productivity',
                'created_at'    => \Carbon\Carbon::now(),
                'updated_at'    => \Carbon\Carbon::now()
            ],
            [
                'blog_category_id'=>5,
                'name'       => 'Business Travel',
                'created_at'    => \Carbon\Carbon::now(),
                'updated_at'    => \Carbon\Carbon::now()
            ],
            [
                'blog_category_id'=>5,
                'name'       => 'Tech Skills',
                'created_at'    => \Carbon\Carbon::now(),
                'updated_at'    => \Carbon\Carbon::now()
            ],
            [
                'blog_category_id'=>5,
                'name'       => 'Communication',
                'created_at'    => \Carbon\Carbon::now(),
                'updated_at'    => \Carbon\Carbon::now()
            ],
            [
                'blog_category_id'=>5,
                'name'       => 'Social Media & Blogging',
                'created_at'    => \Carbon\Carbon::now(),
                'updated_at'    => \Carbon\Carbon::now()
            ],
            [
                'blog_category_id'=>5,
                'name'       => 'Negotiation & Money',
                'created_at'    => \Carbon\Carbon::now(),
                'updated_at'    => \Carbon\Carbon::now()
            ],
            [
                'blog_category_id'=>6,
                'name'       => 'Trending Topics',
                'created_at'    => \Carbon\Carbon::now(),
                'updated_at'    => \Carbon\Carbon::now()
            ],
            [
                'blog_category_id'=>6,
                'name'       => 'Book Reviews',
                'created_at'    => \Carbon\Carbon::now(),
                'updated_at'    => \Carbon\Carbon::now()
            ],
            [
                'blog_category_id'=>6,
                'name'       => 'Lifestyle',
                'created_at'    => \Carbon\Carbon::now(),
                'updated_at'    => \Carbon\Carbon::now()
            ],
            [
                'blog_category_id'=>6,
                'name'       => 'Time Wasters',
                'created_at'    => \Carbon\Carbon::now(),
                'updated_at'    => \Carbon\Carbon::now()
            ],
        ];

        DB::table('blog_sub_cats')->insert($sub_categories);
    }

}
