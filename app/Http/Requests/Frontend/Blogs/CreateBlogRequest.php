<?php namespace App\Http\Requests\Frontend\Blogs;

use App\Http\Requests\Request;

/**
 * Class RegisterRequest
 * @package App\Http\Requests\Frontend\Access
 */
class CreateBlogRequest extends Request {

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
            'heading' 		=> 'required|max:255',
            'blog_category'	=> 'required',
            'blog_sub_cat'		=> 'required',
            'content'=> 'required',
        ];
    }

    public function messages(){
        return [
            'blog_category.required'           => 'Blog Category is required',
            'blog_sub_cat.required'             => 'Blog subCategory is required'
        ];
    }
}
