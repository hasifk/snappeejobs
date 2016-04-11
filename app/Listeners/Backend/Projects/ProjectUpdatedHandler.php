<?php
namespace App\Listeners\Backend\Project;


use App\Events\Backend\NewsFeed\NewsFeedCreated;
use App\Events\Backend\Project\ProjectUpdated;
use App\Events\Backend\Tasks\TaskCreated;
use App\Events\Backend\Tasks\TaskUpdated;
use Carbon\Carbon;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ProjectUpdatedHandler
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


    public function handle(ProjectUpdated $event)
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
                'notification_type' => 'project_updated',
                'details'           => $details,
                'created_at'        => Carbon::now(),
                'updated_at'        => Carbon::now()
            ]);
        }

    }
}
