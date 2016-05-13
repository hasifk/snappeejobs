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
                'url_slug'       => 'getting-started',
                'created_at'    => \Carbon\Carbon::now(),
                'updated_at'    => \Carbon\Carbon::now()
            ],
            [   'blog_category_id'=>1,
                'name'       => 'Getting Ahead ',
                'url_slug'       => 'getting-ahead',
                'created_at'    => \Carbon\Carbon::now(),
                'updated_at'    => \Carbon\Carbon::now()
            ],
            [   'blog_category_id'=>1,
                'name'       => 'Work Relationships ',
                'url_slug'       => 'work-relationships',
                'created_at'    => \Carbon\Carbon::now(),
                'updated_at'    => \Carbon\Carbon::now()
            ],
            [   'blog_category_id'=>1,
                'name'       => 'Changing Jobs ',
                'url_slug'       => 'changing-jobs',
                'created_at'    => \Carbon\Carbon::now(),
                'updated_at'    => \Carbon\Carbon::now()
            ],
            [   'blog_category_id'=>1,
                'name'       => 'Work-Life Balance',
                'url_slug'       => 'work-life-balance',
                'created_at'    => \Carbon\Carbon::now(),
                'updated_at'    => \Carbon\Carbon::now()
            ],
            [
                'blog_category_id'=>1,
                'name'       => 'Working Abroad',
                'url_slug'       => 'working-abroad',
                'created_at'    => \Carbon\Carbon::now(),
                'updated_at'    => \Carbon\Carbon::now()
            ],
            [
                'blog_category_id'=>1,
                'name'       => 'Career Videos',
                'url_slug'       => 'career-videos',
                'created_at'    => \Carbon\Carbon::now(),
                'updated_at'    => \Carbon\Carbon::now()
            ],
            [
                'blog_category_id'=>2,
                'name'       => 'Finding a Job',
                'url_slug'       => 'finding-job',
                'created_at'    => \Carbon\Carbon::now(),
                'updated_at'    => \Carbon\Carbon::now()
            ],
            [
                'blog_category_id'=>2,
                'name'       => 'Resumes & Cover Letters',
                'url_slug'       => 'resumes-coverletters',
                'created_at'    => \Carbon\Carbon::now(),
                'updated_at'    => \Carbon\Carbon::now()
            ],
            [
                'blog_category_id'=>2,
                'name'       => 'Career Videos',
                'url_slug'       => 'career-videos',
                'created_at'    => \Carbon\Carbon::now(),
                'updated_at'    => \Carbon\Carbon::now()
            ],
            [
                'blog_category_id'=>2,
                'name'       => 'Interviewing for a Job',
                'url_slug'       => 'job-interview',
                'created_at'    => \Carbon\Carbon::now(),
                'updated_at'    => \Carbon\Carbon::now()
            ],
            [
                'blog_category_id'=>2,
                'name'       => 'Networking',
                'url_slug'       => 'networking',
                'created_at'    => \Carbon\Carbon::now(),
                'updated_at'    => \Carbon\Carbon::now()
            ],
            [
                'blog_category_id'=>2,
                'name'       => 'Jobs of the Week',
                'url_slug'       => 'jobs-of-the-week',
                'created_at'    => \Carbon\Carbon::now(),
                'updated_at'    => \Carbon\Carbon::now()
            ],
            [
                'blog_category_id'=>2,
                'name'       => 'Jobs Search Videos',
                'url_slug'       => 'job-search-videos',
                'created_at'    => \Carbon\Carbon::now(),
                'updated_at'    => \Carbon\Carbon::now()
            ],

            [
                'blog_category_id'=>3,
                'name'       => 'Finding Your Passion',
                'url_slug'       => 'finding-your-passion',
                'created_at'    => \Carbon\Carbon::now(),
                'updated_at'    => \Carbon\Carbon::now()
            ],
            [
                'blog_category_id'=>3,
                'name'       => 'Exploring Career Paths',
                'url_slug'       => 'exploring-career-paths',
                'created_at'    => \Carbon\Carbon::now(),
                'updated_at'    => \Carbon\Carbon::now()
            ],
            [
                'blog_category_id'=>3,
                'name'       => 'Career Changes',
                'url_slug'       => 'career-changes',
                'created_at'    => \Carbon\Carbon::now(),
                'updated_at'    => \Carbon\Carbon::now()
            ],
            [
                'blog_category_id'=>3,
                'name'       => 'Grad School',
                'url_slug'       => 'grad-school',
                'created_at'    => \Carbon\Carbon::now(),
                'updated_at'    => \Carbon\Carbon::now()
            ],
            [
                'blog_category_id'=>4,
                'name'       => 'Hiring',
                'url_slug'       => 'hiring',
                'created_at'    => \Carbon\Carbon::now(),
                'updated_at'    => \Carbon\Carbon::now()
            ],
            [
                'blog_category_id'=>4,
                'name'       => 'Conflict Resolution',
                'url_slug'       => 'conflict-resolution',
                'created_at'    => \Carbon\Carbon::now(),
                'updated_at'    => \Carbon\Carbon::now()
            ],
            [
                'blog_category_id'=>4,
                'name'       => 'Management Style',
                'url_slug'       => 'management-style',
                'created_at'    => \Carbon\Carbon::now(),
                'updated_at'    => \Carbon\Carbon::now()
            ],
            [
                'blog_category_id'=>4,
                'name'       => 'Team Culture',
                'url_slug'       => 'team-culture',
                'created_at'    => \Carbon\Carbon::now(),
                'updated_at'    => \Carbon\Carbon::now()
            ],
            [
                'blog_category_id'=>5,
                'name'       => 'Productivity',
                'url_slug'       => 'productivity',
                'created_at'    => \Carbon\Carbon::now(),
                'updated_at'    => \Carbon\Carbon::now()
            ],
            [
                'blog_category_id'=>5,
                'name'       => 'Business Travel',
                'url_slug'       => 'business-travel',
                'created_at'    => \Carbon\Carbon::now(),
                'updated_at'    => \Carbon\Carbon::now()
            ],
            [
                'blog_category_id'=>5,
                'name'       => 'Tech Skills',
                'url_slug'       => 'tech-skills',
                'created_at'    => \Carbon\Carbon::now(),
                'updated_at'    => \Carbon\Carbon::now()
            ],
            [
                'blog_category_id'=>5,
                'name'       => 'Communication',
                'url_slug'       => 'communication',
                'created_at'    => \Carbon\Carbon::now(),
                'updated_at'    => \Carbon\Carbon::now()
            ],
            [
                'blog_category_id'=>5,
                'name'       => 'Social Media & Blogging',
                'url_slug'       => 'social-media-blogging',
                'created_at'    => \Carbon\Carbon::now(),
                'updated_at'    => \Carbon\Carbon::now()
            ],
            [
                'blog_category_id'=>5,
                'name'       => 'Negotiation & Money',
                'url_slug'       => 'negotiation-money',
                'created_at'    => \Carbon\Carbon::now(),
                'updated_at'    => \Carbon\Carbon::now()
            ],
            [
                'blog_category_id'=>6,
                'name'       => 'Trending Topics',
                'url_slug'       => 'trending-topics',
                'created_at'    => \Carbon\Carbon::now(),
                'updated_at'    => \Carbon\Carbon::now()
            ],
            [
                'blog_category_id'=>6,
                'name'       => 'Book Reviews',
                'url_slug'       => 'book-reviews',
                'created_at'    => \Carbon\Carbon::now(),
                'updated_at'    => \Carbon\Carbon::now()
            ],
            [
                'blog_category_id'=>6,
                'name'       => 'Lifestyle',
                'url_slug'       => 'lifestyle',
                'created_at'    => \Carbon\Carbon::now(),
                'updated_at'    => \Carbon\Carbon::now()
            ],
            [
                'blog_category_id'=>6,
                'name'       => 'Time Wasters',
                'url_slug'       => 'time-wasters',
                'created_at'    => \Carbon\Carbon::now(),
                'updated_at'    => \Carbon\Carbon::now()
            ],
        ];

        DB::table('blog_sub_cats')->insert($sub_categories);
    }

}
