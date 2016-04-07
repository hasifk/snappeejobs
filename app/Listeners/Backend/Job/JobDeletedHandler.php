<?php

namespace App\Listeners\Backend\Job;

use App\Events\Backend\Job\JobDeleted;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class JobDeletedHandler
{
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
     * @param  JobDeleted  $event
     * @return void
     */
    public function handle(JobDeleted $event)
    {
        // Insert into employer_notifications table for all the employers of this company

        $staffs = \DB::table('staff_employer')->where('employer_id', $event->user->employer_id)->lists('user_id');

        $user = $event->user->attributesToArray();
        $job = $event->job->attributesToArray();

        $details = serialize([
            'user'  => $user,
            'job'   => $job
        ]);

        foreach ($staffs as $staff) {
            \DB::table('employer_notifications')->insert([
                'employer_id'       => $user['employer_id'],
                'user_id'           => $staff,
                'notification_type' => 'job_deleted',
                'details'           => $details,
                'created_at'        => Carbon::now(),
                'updated_at'        => Carbon::now()
            ]);
        }
    }
}
