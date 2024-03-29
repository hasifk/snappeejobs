<?php

namespace app\Models\Access\User\Traits;

/**
 * Class EmployerAccess
 * @package App\Models\Access\User\Traits
 */
trait EmployerAccess
{

    public $employerSubscribed = false;
    public $employer = null;
    public $employerHasCompany = null;
    public $employerCompany = null;

    public function isEmployerSubscribed(){

        $employer_id = \DB::table('staff_employer')
            ->where('user_id', $this->id)
            ->orderBy('created_at')
            ->value('employer_id');

        if (! $employer_id) {
            return false;
        }

        $employer_plan_exists = \DB::table('employer_plan')
            ->where('employer_id', $employer_id)
            ->count();

        if (! $employer_plan_exists ) {
            return false;
        }

        $this->employerSubscribed = true;
        $this->employer = \DB::table('employer_plan')->where('employer_id', $employer_id)->first();
        return true;
    }

    public function employerHasCompany(){

        if (! $this->employer_id) {
            return false;
        }

        $employer_company_exists = \DB::table('companies')
            ->where('employer_id', $this->employer_id)
            ->count();

        if (! $employer_company_exists ) {
            return false;
        }

        $this->employerHasCompany = true;
        $this->employerCompany = \DB::table('companies')->where('employer_id', $this->employer_id)->first();
        return true;
    }

}
