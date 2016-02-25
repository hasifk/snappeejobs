<?php

namespace App\Http\Requests\Backend\Employer\Staff;

use App\Exceptions\Backend\Company\CompanyNeedDataFilledException;
use App\Http\Requests\Request;

class CreateEmployerPageRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return access()->can('create-employer-staff');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        $totalEmployerCount = \DB::table('staff_employer')
            ->join('users', 'users.id', '=', 'staff_employer.user_id')
            ->where('staff_employer.employer_id', auth()->user()->employer_id)
            ->whereNull('users.deleted_at')
            ->count();

        if ( auth()->user()->employerPlan && $totalEmployerCount >= auth()->user()->employerPlan->staff_members ) {
            $exception = new CompanyNeedDataFilledException();
            $exception->setValidationErrors('You have exceeded the limit of staff members allotted for this account.');
            throw $exception;
        }

        return [
            //
        ];
    }
}
