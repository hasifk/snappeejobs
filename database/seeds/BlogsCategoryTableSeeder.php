<?php

use Illuminate\Database\Seeder;

class BlogsCategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [

            [
                'name'       => 'Career Advice',
                'url_slug'       => 'career-advice',
                'created_at'    => \Carbon\Carbon::now(),
                'updated_at'    => \Carbon\Carbon::now()
            ],
            [
                'name'       => 'Job Search',
                'url_slug'       => 'job-search',
                'created_at'    => \Carbon\Carbon::now(),
                'updated_at'    => \Carbon\Carbon::now()
            ],
            [
                'name'       => 'Career Paths',
                'url_slug'       => 'career-paths',
                'created_at'    => \Carbon\Carbon::now(),
                'updated_at'    => \Carbon\Carbon::now()
            ],
            [
                'name'       => 'Management',
                'url_slug'       => 'management',
                'created_at'    => \Carbon\Carbon::now(),
                'updated_at'    => \Carbon\Carbon::now()
            ],
            [
                'name'       => 'Tools & Skills',
                'url_slug'       => 'tools-skills',
                'created_at'    => \Carbon\Carbon::now(),
                'updated_at'    => \Carbon\Carbon::now()
            ],
            [
                'name'       => 'Breakroom ',
                'url_slug'       => 'breakroom',
                'created_at'    => \Carbon\Carbon::now(),
                'updated_at'    => \Carbon\Carbon::now()
            ],
        ];

        DB::table('blog_categories')->insert($categories);
    }
}
