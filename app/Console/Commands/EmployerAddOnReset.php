<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class EmployerAddOnReset extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'snappeejobs:employeraddonreset';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset all the employer Add on parameters to the value of the plan';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $employer_plans = \DB::table('employer_plan')->lists('employer_id');
        foreach ($employer_plans as $employer_id) {
            $plan_name = \DB::table('users')->where('id', $employer_id)->value('stripe_plan');
            foreach (config('subscription.employer_plans') as $key => $plan) {
                if ( $plan['id'] == $plan_name ) {
                     $addons = config('subscription.employer_plans')[$key]['addons'];


                    $addon_update_array = [];

                    foreach ($addons as $addon_key => $addon) {
                        $addon_update_array[$addon_key] = $addon['count'];
                    }

                    \DB::table('employer_plan')->where('employer_id', $employer_id)
                        ->update($addon_update_array);
                }
            }
        }
    }
}
