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
                'name'       => 'CAREER ADVICE ',
                'created_at'    => \Carbon\Carbon::now(),
                'updated_at'    => \Carbon\Carbon::now()
            ],
            [
                'name'       => 'JOB SEARCH ',
                'created_at'    => \Carbon\Carbon::now(),
                'updated_at'    => \Carbon\Carbon::now()
            ],
            [
                'name'       => 'CAREER PATHS ',
                'created_at'    => \Carbon\Carbon::now(),
                'updated_at'    => \Carbon\Carbon::now()
            ],
            [
                'name'       => 'MANAGEMENT ',
                'created_at'    => \Carbon\Carbon::now(),
                'updated_at'    => \Carbon\Carbon::now()
            ],
            [
                'name'       => 'TOOLS & SKILLS ',
                'created_at'    => \Carbon\Carbon::now(),
                'updated_at'    => \Carbon\Carbon::now()
            ],
            [
                'name'       => 'BREAKROOM ',
                'created_at'    => \Carbon\Carbon::now(),
                'updated_at'    => \Carbon\Carbon::now()
            ],
        ];

        DB::table('blog_categories')->insert($categories);
    }
}
