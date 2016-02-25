<?php

namespace App\Http\Requests\Backend\Admin\Company;

use App\Exceptions\Backend\Company\CompanyNeedDataFilledException;
use App\Http\Requests\Request;
use App\Models\Company\NewCompanyTemp\NewCompanyTemp;

class NewCompanyValidRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return access()->can('company-management');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        $newCompanyTemp = NewCompanyTemp::where('employer_id', $this->segment(4))->first();

        if ( ! $newCompanyTemp->employer->subscribed() ) {
            $this->throwException();
        }


        return [
            //
        ];
    }

    private function throwException(){
        $exception = new CompanyNeedDataFilledException();
        $exception->setValidationErrors('This company has not been paid yet.');

        throw $exception;
    }
}
