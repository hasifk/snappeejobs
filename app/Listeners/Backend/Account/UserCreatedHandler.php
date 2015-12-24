<?php

namespace App\Listeners\Backend\Account;

use App\Events\Backend\Account\UserCreated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;

class UserCreatedHandler
{

    use InteractsWithQueue;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  UserCreated  $event
     * @return void
     */
    public function handle(UserCreated $event)
    {

        $user = $event->newUser;
        $createdUser = $event->createdUser;

        \Log::info("User created In: ".$user->name);

        $userIsEmployer = \DB::table('assigned_roles')
            ->where('user_id', $user->id)
            ->where('role_id', config('access.employers.default_role'))
            ->count();

        if ( $userIsEmployer ) {
            \Log::info("Employer user is created In: ".$user->name);

            $employer = \DB::table('staff_employer')
                ->where('employer_id', $user->id)
                ->where('user_id', $user->id)
                ->where('is_admin', true)
                ->count();

            if (! $employer) {
                \DB::table('staff_employer')->insert([
                    'employer_id'   => $user->id,
                    'user_id'       => $user->id,
                    'is_admin'      => true,
                    'created_at'    => \Carbon\Carbon::now(),
                    'updated_at'    => \Carbon\Carbon::now()
                ]);
            }
        }

        $userIsEmployerStaff = \DB::table('assigned_roles')
            ->where('user_id', $user->id)
            ->where('role_id', config('access.employer_staff.default_role'))
            ->count();

        if ( $userIsEmployerStaff ) {
            \Log::info("Employer Staff user is created In: ".$user->name);

            $employerStaff = \DB::table('staff_employer')
                ->where('employer_id', $user->id)
                ->where('user_id', $user->id)
                ->where('is_admin', false)
                ->count();

            if (! $employerStaff) {
                \DB::table('staff_employer')->insert([
                    'employer_id'   => $createdUser->id,
                    'user_id'       => $user->id,
                    'is_admin'      => false,
                    'created_at'    => \Carbon\Carbon::now(),
                    'updated_at'    => \Carbon\Carbon::now()
                ]);
            }
        }


    }
}
