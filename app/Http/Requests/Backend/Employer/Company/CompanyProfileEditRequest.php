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

        if ( $this->request->get('video_url') ) {
            foreach ($this->request->get('video_url') as $key => $item) {
                if ( ! empty($item) ) {
                    $rules['video_url.'.$key] = 'required|url';
                }
            }
        }

        $people_names           = $this->request->get('people_name');
        $job_position           = $this->request->get('job_position');
        $people_about           = $this->request->get('people_about');
        $people_testimonial     = $this->request->get('people_testimonial');
        $avatar_image           = $this->request->get('avatar_image');

        if (
            ( $people_names[0] ) ||
            ( $job_position[0] ) ||
            ( $people_about[0] ) ||
            ( $people_testimonial[0] )
        ) {
            $rules['people_name.0']         = 'required';
            $rules['job_position.0']        = 'required';
            $rules['people_about.0']        = 'required';
            $rules['people_testimonial.0']  = 'required';
            if (! $avatar_image[0] ) {
                $rules['people_avatar_0']       = 'required|image|max:1024|mimes:jpeg,jpg,png';
            }
        }



        if (
            ( $people_names[1] ) ||
            ( $job_position[1] ) ||
            ( $people_about[1] ) ||
            ( $people_testimonial[1] )
        ) {
            $rules['people_name.1']         = 'required';
            $rules['job_position.1']        = 'required';
            $rules['people_about.1']        = 'required';
            $rules['people_testimonial.1']  = 'required';
            if (! $avatar_image[1] ) {
                $rules['people_avatar_1']       = 'required|image|max:1024|mimes:jpeg,jpg,png';
            }
        }

        if (
            ( $people_names[2] ) ||
            ( $job_position[2] ) ||
            ( $people_about[2] ) ||
            ( $people_testimonial[2] )
        ) {
            $rules['people_name.2']         = 'required';
            $rules['job_position.2']        = 'required';
            $rules['people_about.2']        = 'required';
            $rules['people_testimonial.2']  = 'required';
            if (! $avatar_image[2] ) {
                $rules['people_avatar_2']       = 'required|image|max:1024|mimes:jpeg,jpg,png';
            }
        }

        if (
            ( $people_names[3] ) ||
            ( $job_position[3] ) ||
            ( $people_about[3] ) ||
            ( $people_testimonial[3] )
        ) {
            $rules['people_name.3']         = 'required';
            $rules['job_position.3']        = 'required';
            $rules['people_about.3']        = 'required';
            $rules['people_testimonial.3']  = 'required';
            if (! $avatar_image[3] ) {
                $rules['people_avatar_3']       = 'required|image|max:1024|mimes:jpeg,jpg,png';
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

        if ( $this->request->get('video_url') ) {
            foreach ($this->request->get('video_url') as $key => $item) {
                if ( ! empty($item) ) {
                    $messages['video_url.'.$key.'.url'] = 'Video URL is not a valid URL ';
                }
            }
        }

        $avatar_images = $this->request->get('people_avatar');
        $people_names = $this->request->get('people_name');
        $job_position = $this->request->get('job_position');
        $people_about = $this->request->get('people_about');
        $people_testimonial = $this->request->get('people_testimonial');

        if (
            ( $avatar_images[0] ) ||
            ( $people_names[0] ) ||
            ( $job_position[0] ) ||
            ( $people_about[0] ) ||
            ( $people_testimonial[0] )
        ) {
            $messages['people_avatar_0.required']                = 'Company people first avatar is required';
            $messages['people_avatar_0.image']                   = 'Company people first avatar must be an image';
            $messages['people_avatar_0.mimes']                   = 'Company people first avatar  must be a file of type: jpeg, jpg, png.';
            $messages['people_avatar_0.max']                     = 'Company people first avatar  may not be greater than :max kilobytes.';
            $messages['people_name.0.required']                  = 'Company people first name is required';
            $messages['job_position.0.required']                 = 'Company people first job position is required';
            $messages['people_about.0.required']                 = 'Company people first about is required';
            $messages['people_testimonial.0.required']           = 'Company people first testimonial is required';
        }

        if (
            ( $avatar_images[1] ) ||
            ( $people_names[1] ) ||
            ( $job_position[1] ) ||
            ( $people_about[1] ) ||
            ( $people_testimonial[1] )
        ) {
            $messages['people_avatar_1.required']                = 'Company people second avatar is required';
            $messages['people_avatar_1.image']                   = 'Company people second avatar must be an image';
            $messages['people_avatar_1.mimes']                   = 'Company people second avatar  must be a file of type: jpeg, jpg, png.';
            $messages['people_avatar_1.max']                     = 'Company people second avatar  may not be greater than :max kilobytes.';
            $messages['people_name.1.required']                  = 'Company people second name is required';
            $messages['job_position.1.required']                 = 'Company people second job position is required';
            $messages['people_about.1.required']                 = 'Company people second about is required';
            $messages['people_testimonial.1.required']           = 'Company people second testimonial is required';
        }

        if (
            ( $avatar_images[2] ) ||
            ( $people_names[2] ) ||
            ( $job_position[2] ) ||
            ( $people_about[2] ) ||
            ( $people_testimonial[2] )
        ) {
            $messages['people_avatar_2.required']                = 'Company people third avatar is required';
            $messages['people_avatar_2.image']                   = 'Company people third avatar must be an image';
            $messages['people_avatar_2.mimes']                   = 'Company people third avatar  must be a file of type: jpeg, jpg, png.';
            $messages['people_avatar_2.max']                     = 'Company people third avatar  may not be greater than :max kilobytes.';
            $messages['people_name.2.required']                  = 'Company people third name is required';
            $messages['job_position.2.required']                 = 'Company people third job position is required';
            $messages['people_about.2.required']                 = 'Company people third about is required';
            $messages['people_testimonial.2.required']           = 'Company people third testimonial is required';
        }

        if (
            ( $avatar_images[3] ) ||
            ( $people_names[3] ) ||
            ( $job_position[3] ) ||
            ( $people_about[3] ) ||
            ( $people_testimonial[3] )
        ) {
            $messages['people_avatar_3.required']                = 'Company people fourth avatar is required';
            $messages['people_avatar_3.image']                   = 'Company people fourth avatar must be an image';
            $messages['people_avatar_3.mimes']                   = 'Company people fourth avatar  must be a file of type: jpeg, jpg, png.';
            $messages['people_avatar_3.max']                     = 'Company people fourth avatar  may not be greater than :max kilobytes.';
            $messages['people_name.3.required']                  = 'Company people fourth name is required';
            $messages['job_position.3.required']                 = 'Company people fourth job position is required';
            $messages['people_about.3.required']                 = 'Company people fourth about is required';
            $messages['people_testimonial.3.required']           = 'Company people fourth testimonial is required';
        }

        return $messages;
    }
}
