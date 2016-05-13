<?php namespace App\Http\Requests\Backend\Blogs;

use App\Http\Requests\Request;

/**
 * Class RegisterRequest
 * @package App\Http\Requests\Frontend\Access
 */
class BlogRequest extends Request
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
            'title' => 'required|max:255',
            'blog_category' => 'required',
            'blog_sub_cat' => 'required',
            'videolink' => 'youtube_vimeo',
            'content' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'blog_category.required' => 'Blog Category is required',
            'blog_sub_cat.required' => 'Blog subCategory is required',
            'videolink.required' => 'Youtube/vimeo Field cannot be empty',
            'videolink.youtube_vimeo' => 'Please enter a valid Youtube/vimeo link'
        ];
    }
}
