<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class EmployerSubscriptionPlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('users')->where('name', 'Silverbloom Technologies')->update([
            'stripe_active'         => true,
            'stripe_id'             => 'cus_7gJaBfqYQIR9CA',
            'stripe_subscription'   => 'sub_7gJa6oewdsP5Tf',
            'stripe_plan'           => 'snappeejobs1',
            'last_four'             => 4242
        ]);

        \DB::table('employer_plan')->insert([
            'employer_id'       => 2,
            'job_postings'      => 10,
            'staff_members'     => 10,
            'chats_accepted'    => 10,
            'created_at'        => Carbon::now(),
            'updated_at'        => Carbon::now()
        ]);
    }
}
