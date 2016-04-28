<?php

namespace App\Listeners\Backend\Company;

use App\Events\Backend\Company\CompanyUpdated;
use App\Events\Backend\Job\JobUpdated;
use Carbon\Carbon;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class CompanyUpdatedHandler
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
     * @param  JobUpdated  $event
     * @return void
     */
    public function handle(CompanyUpdated $event)
    {
        // Insert into employer_notifications table for all the employers of this company

        $staffs = \DB::table('staff_employer')->where('employer_id', $event->company->employer_id)->lists('user_id');

        $company = $event->company->attributesToArray();

        $details = serialize([
            'company'  => $company
        ]);

        foreach ($staffs as $staff) {
            \DB::table('employer_notifications')->insert([
                'employer_id'       => $company['employer_id'],
                'user_id'           => $staff,
                'notification_type' => 'company_information_updated',
                'details'           => $details,
                'created_at'        => Carbon::now(),
                'updated_at'        => Carbon::now()
            ]);
        }

    }
}
