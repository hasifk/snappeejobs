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

    public function isEmployerSubscribed(){
        $employer_id = \DB::table('staff_employer')
            ->where('user_id', $this->id)
            ->where('is_admin', true)
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
}