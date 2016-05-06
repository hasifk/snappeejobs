<?php

use Illuminate\Database\Seeder;

class CmsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $information = [

            [
                'user_id'       => 1,
                'header'        => 'About Us',
                'type'          => 'Article',
                'content'       => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec semper augue placerat leo eleifend, ac ullamcorper nunc vulputate. Cras finibus est ut varius maximus. Sed eu dolor a tellus dapibus dapibus. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Mauris at ex vel libero tristique feugiat vel quis lectus. Nulla in dolor libero. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Aliquam quis ante in felis pellentesque ornare. Proin interdum elementum nulla, in malesuada odio auctor et. Etiam at iaculis dolor, in finibus ex. Quisque iaculis dictum dui, sit amet viverra leo malesuada non. Morbi quis dolor non nisi pretium mattis vel a magna. Donec eu quam metus.',
                'published'     =>1,
                'created_at'    => \Carbon\Carbon::now(),
                'updated_at'    => \Carbon\Carbon::now()
            ],
            [
                'user_id'       => 1,
                'header'             => 'Terms & Conditions',
                'type'          => 'Article',
                'content'              => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec semper augue placerat leo eleifend, ac ullamcorper nunc vulputate. Cras finibus est ut varius maximus. Sed eu dolor a tellus dapibus dapibus. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Mauris at ex vel libero tristique feugiat vel quis lectus. Nulla in dolor libero. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Aliquam quis ante in felis pellentesque ornare. Proin interdum elementum nulla, in malesuada odio auctor et. Etiam at iaculis dolor, in finibus ex. Quisque iaculis dictum dui, sit amet viverra leo malesuada non. Morbi quis dolor non nisi pretium mattis vel a magna. Donec eu quam metus.',
                'published'     =>1,
                'created_at'        => \Carbon\Carbon::now(),
                'updated_at'        => \Carbon\Carbon::now()
            ],
            [
                'user_id'       => 1,
                'header'             => 'Privacy Policy',
                'type'          => 'Article',
                'content'              => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec semper augue placerat leo eleifend, ac ullamcorper nunc vulputate. Cras finibus est ut varius maximus. Sed eu dolor a tellus dapibus dapibus. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Mauris at ex vel libero tristique feugiat vel quis lectus. Nulla in dolor libero. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Aliquam quis ante in felis pellentesque ornare. Proin interdum elementum nulla, in malesuada odio auctor et. Etiam at iaculis dolor, in finibus ex. Quisque iaculis dictum dui, sit amet viverra leo malesuada non. Morbi quis dolor non nisi pretium mattis vel a magna. Donec eu quam metus.',
                'published'     =>1,
                'created_at'        => \Carbon\Carbon::now(),
                'updated_at'        => \Carbon\Carbon::now()
            ],
            [
                'user_id'       => 1,
                'header'             => 'Careers with Us',
                'type'          => 'Article',
                'content'              => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec semper augue placerat leo eleifend, ac ullamcorper nunc vulputate. Cras finibus est ut varius maximus. Sed eu dolor a tellus dapibus dapibus. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Mauris at ex vel libero tristique feugiat vel quis lectus. Nulla in dolor libero. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Aliquam quis ante in felis pellentesque ornare. Proin interdum elementum nulla, in malesuada odio auctor et. Etiam at iaculis dolor, in finibus ex. Quisque iaculis dictum dui, sit amet viverra leo malesuada non. Morbi quis dolor non nisi pretium mattis vel a magna. Donec eu quam metus.',
                'published'     =>1,
                'created_at'        => \Carbon\Carbon::now(),
                'updated_at'        => \Carbon\Carbon::now()
            ],
            [
                'user_id'       => 1,
                'header'             => 'Contact Us',
                'type'          => 'Article',
                'content'              => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec semper augue placerat leo eleifend, ac ullamcorper nunc vulputate. Cras finibus est ut varius maximus. Sed eu dolor a tellus dapibus dapibus. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Mauris at ex vel libero tristique feugiat vel quis lectus. Nulla in dolor libero. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Aliquam quis ante in felis pellentesque ornare. Proin interdum elementum nulla, in malesuada odio auctor et. Etiam at iaculis dolor, in finibus ex. Quisque iaculis dictum dui, sit amet viverra leo malesuada non. Morbi quis dolor non nisi pretium mattis vel a magna. Donec eu quam metus.',
                'published'     =>1,
                'created_at'        => \Carbon\Carbon::now(),
                'updated_at'        => \Carbon\Carbon::now()
            ],
            [
                'user_id'       => 1,
                'header'             => 'FAQs',
                'type'          => 'Article',
                'content'              => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec semper augue placerat leo eleifend, ac ullamcorper nunc vulputate. Cras finibus est ut varius maximus. Sed eu dolor a tellus dapibus dapibus. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Mauris at ex vel libero tristique feugiat vel quis lectus. Nulla in dolor libero. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Aliquam quis ante in felis pellentesque ornare. Proin interdum elementum nulla, in malesuada odio auctor et. Etiam at iaculis dolor, in finibus ex. Quisque iaculis dictum dui, sit amet viverra leo malesuada non. Morbi quis dolor non nisi pretium mattis vel a magna. Donec eu quam metus.',
                'published'     =>1,
                'created_at'        => \Carbon\Carbon::now(),
                'updated_at'        => \Carbon\Carbon::now()
            ],
        ];

        DB::table('cms')->insert($information);
    }
}
