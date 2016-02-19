<?php

namespace App\Http\Requests\Frontend\Access;

use App\Http\Requests\Request;

class ProfileImagesUploadRequest extends Request
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
            config('mimes.jpeg'),
            config('mimes.jpg'),
            config('mimes.jpe'),
            config('mimes.png')
        ];

        $mimeTypes = array_flatten($mimeTypes);

        if ( ! in_array($video->getClientMimeType(), $mimeTypes) ) {
            $rules['file'] = 'required';
        } else {
            $rules['file'] = 'image|max:5000|mimes:jpeg,jpg,png';
        }

        return $rules;
    }
}
