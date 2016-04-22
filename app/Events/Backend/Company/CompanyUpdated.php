<?php

namespace App\Events\Backend\Company;

use App\Events\Event;
use App\Models\Access\User\User;
use App\Models\Company\Company;
use App\Models\Job\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class CompanyUpdated extends Event implements ShouldBroadcast
{
    use SerializesModels;

    /**
     * @var Job
     */
    public $company;
    /**
     * @var
     */

    public $eventDetails;

    /**
     * Create a new event instance.
     *
     * @param Job $job
     * @param User $user
     */
    public function __construct(Company $company)
    {
        $this->company = $company;

        $this->eventDetails = new \stdClass();

        $this->eventDetails->{'notification_type'} = 'company_information_updated';
        $this->eventDetails->{'notification_type_text'} = 'Company Information Updated';
        $this->eventDetails->{'company_title'} = $company->title;
        $this->eventDetails->{'created_by'} = 'Admin';
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        $staffs = \DB::table('staff_employer')->where('employer_id', $this->company->employer_id)->lists('user_id');

        $broadCastOn = [];

        foreach ($staffs as $staff) {
            $broadCastOn[] = 'employer_staff.'.$staff;
        }

        return $broadCastOn;
    }

    public function broadcastAs(){
        return 'company_notifications';
    }
}
