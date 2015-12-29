<?php

namespace App\Events\Backend\Company;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class CompanyCreated extends Event
{
    use SerializesModels;
    /**
     * @var Company
     */
    public $company;
    /**
     * @var int
     */
    public $employerId;

    /**
     * Create a new event instance.
     *
     * @param Company $company
     * @param int $employerId
     */
    public function __construct(Company $company, $employerId = 0)
    {
        //
        $this->company = $company;
        $this->employerId = $employerId;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [];
    }
}
