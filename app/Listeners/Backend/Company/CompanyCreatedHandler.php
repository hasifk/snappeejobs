<?php

namespace App\Listeners\Backend\Company;

use App\Events\Backend\Company\CompanyCreated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class CompanyCreatedHandler
{
    private $company;
    private $employerId;

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
     * @param  CompanyCreated  $event
     * @return void
     */
    public function handle(CompanyCreated $event)
    {
        $this->company = $event->company;
        $this->employerId = $event->employerId;

        \Log::info("Company created In: ".$this->company->title. " with employer id " . $this->employerId);
    }
}
