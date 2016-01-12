<?php

namespace App\Http\Requests\Frontend\Access;

use App\Http\Requests\Request;

class ResumeUploadRequest extends Request
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

        $resume = $this->file('file');

        $mimeTypes = [
            config('mimes.doc'),
            config('mimes.docx'),
            config('mimes.word'),
            config('mimes.rtf'),
            config('mimes.pdf'),
        ];

        $mimeTypes = array_flatten($mimeTypes);

        if ( ! in_array($resume->getClientMimeType(), $mimeTypes) ) {
            $rules['file'] = 'required';
        } else {
            $rules['file'] = 'required|max:5000';
        }

        return $rules;
    }
}
