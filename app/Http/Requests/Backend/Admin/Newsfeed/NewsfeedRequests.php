<?php

namespace App\Http\Requests\Backend\Admin\Newsfeed;

use App\Http\Requests\Request;

/**
 * Class RegisterRequest
 * @package App\Http\Requests\Frontend\Access
 */
class NewsfeedRequests extends Request
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
        return [
            'newsfeed' => 'required',
        ];
    }
}