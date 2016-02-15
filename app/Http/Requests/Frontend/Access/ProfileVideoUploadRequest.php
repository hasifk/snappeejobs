<?php

namespace App\Http\Requests\Frontend\Access;

use App\Http\Requests\Request;

class ProfileVideoUploadRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [];

        $video = $this->file('file');

        $mimeTypes = [
            config('mimes.flv'),
            config('mimes.mp4'),
            config('mimes.mpeg'),
            config('mimes.mpg'),
            config('mimes.avi')
        ];

        $mimeTypes = array_flatten($mimeTypes);

        if ( ! in_array($video->getClientMimeType(), $mimeTypes) ) {
            $rules['file'] = 'required';
        } else {
            $rules['file'] = 'required|max:5000';
        }

        return $rules;
    }
}
