<?php

namespace App\Events\Frontend\Job;

use App\Events\Event;
use App\Models\Access\User\User;
use Carbon\Carbon;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class JobApplied extends Event implements ShouldBroadcast
{
    use SerializesModels;

    public $jobApplication;
    private $employers;

    public function __construct($job_application_id)
    {

        $jobApplication = \DB::table('job_applications')
            ->join('jobs', 'jobs.id', '=', 'job_applications.job_id')
            ->join('users', 'job_applications.user_id', '=', 'users.id')
            ->where('job_applications.id', $job_application_id )
            ->where(function($query){
                $query->whereNull('job_applications.accepted_at' )
                    ->orWhereNull('job_applications.declined_at');
            })
            ->select([
                'job_applications.id',
                'job_applications.job_id',
                'jobs.title',
                'users.name',
                \DB::raw('users.id AS user_id'),
                'job_applications.created_at'
            ])
            ->first();

        $applicant = User::find($jobApplication->user_id);

        $jobApplication->{'image'} = $applicant->getPictureAttribute(25, 25);
        $jobApplication->{'name'} = $applicant->name;
        $jobApplication->{'was_created'} = Carbon::parse($jobApplication->created_at)->diffForHumans();

        $employer_id = \DB::table('companies')
            ->join('jobs', 'jobs.company_id', '=', 'companies.id')
            ->where('jobs.id', $jobApplication->job_id)->value('companies.employer_id');
        $employersToBeNotified = \DB::table('staff_employer')->where('employer_id', $employer_id)->lists('user_id');
        $employers = User::whereIn('id', $employersToBeNotified)->get();

        $this->jobApplication = $jobApplication;
        $this->employers = $employers;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        $user_ids = $this->employers->map(function($user, $key) {
            return 'user.' . $user->id;
        });

        return $user_ids->all();
    }

    /**
     * The event name to be broadcasted
     * @return string
     */
    public function broadcastAs(){
        return 'jobapplication-received';
    }
}
