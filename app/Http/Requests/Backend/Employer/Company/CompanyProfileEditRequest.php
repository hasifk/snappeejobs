<?php

namespace App\Http\Requests\Backend\Employer\Company;

use App\Http\Requests\Request;

class CompanyProfileEditRequest extends Request
{
    private $socialMedia = ['Twitter', 'Facebook', 'Instagram', 'Pinterest'];

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return access()->can('company-profile-edit');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'title'             => 'required',
            'size'              => 'required|in:small,medium,big',
            'industry_company'  => 'required|array',
            'description'       => 'required',
            'what_it_does'      => 'required',
            'office_life'       => 'required',
            'country_id'        => 'required',
            'state_id'          => 'required',
        ];

        if ( $this->request->get('social_media') ) {
            foreach ($this->request->get('social_media') as $key => $item) {
                if ( ! empty($item) ) {
                    $rules['social_media.'.$key] = 'required|url';
                }
            }
        }

        return $rules;
    }

    public function messages(){
        $messages = [
            'title.required'                => 'Title is required',
            'size.required'                 => 'Size is required',
            'industry_company.required'     => 'Any of industries is required',
            'description.required'          => 'Description is required',
            'what_it_does.required'         => 'What it does is required',
            'office_life.required'          => 'Office life is required',
            'country_id.required'           => 'Country is required',
            'state_id.required'             => 'State is required',
        ];

        if ( $this->request->get('social_media') ) {
            foreach ($this->request->get('social_media') as $key => $item) {
                if ( ! empty($item) ) {
                    $messages['social_media.'.$key.'.url'] = 'Social Media URL for '.
                        $this->socialMedia[$key] .' is not a valid URL ';
                }
            }
        }

        return $messages;
    }
}
