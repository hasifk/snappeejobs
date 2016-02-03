<?php

namespace App\Providers;

use App\Models\Access\User\User;
use Illuminate\Support\ServiceProvider;

class ModelUpdateServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {

        User::updated(function($user){

            if ( in_array('User', $user->roles()->lists('name')->toArray()) ) {

                $updateArray = [];

                $user->country_id ? $updateArray['country_id'] = $user->country_id : '';
                $user->state_id ? $updateArray['state_id'] = $user->state_id : '';

                if (! empty($updateArray)) {
                    \DB::table('job_seeker_details')
                        ->where('user_id', $user->id)
                        ->update($updateArray);
                }
            }
        });

    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
