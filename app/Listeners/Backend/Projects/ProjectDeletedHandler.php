<?php
namespace App\Listeners\Backend\Project;

use App\Events\Backend\Project\ProjectDeleted;

use Carbon\Carbon;

class ProjectDeletedHandler
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


    public function handle(ProjectDeleted $event)
    {
        // Insert into employer_notifications table for all the employers of this company

        $staffs = \DB::table('staff_employer')->where('employer_id',$event->user->employer_id)->lists('user_id');

        $user = $event->user->attributesToArray();
        $project = $event->project->attributesToArray();

        $details = serialize([
            'user'  => $user,
            'project'   => $project
        ]);

        foreach ($staffs as $staff) {
            \DB::table('employer_notifications')->insert([
                'employer_id'       => $user['employer_id'],
                'user_id'           => $staff,
                'from_admin'        =>0,
                'notification_type' => 'project_deleted',
                'details'           => $details,
                'created_at'        => Carbon::now(),
                'updated_at'        => Carbon::now()
            ]);
        }

    }
}
