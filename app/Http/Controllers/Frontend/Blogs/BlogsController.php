<?php

namespace App\Http\Controllers\Frontend\Blogs;

use App\Models\Access\User\User;
use App\Models\Blogs\BlogCategories;
use App\Models\Blogs\BlogSubCategories;
use App\Repositories\Frontend\Blogs\EloquentBlogRepository;
use App\Repositories\Frontend\JobSeeker\EloquentJobSeekerRepository;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class BlogsController extends Controller
{
    /**
     * @var EloquentJobSeekerRepository
     */
    private $repository;

    /**
     * BlogsController constructor.
     * @param EloquentJobSeekerRepository $repository
     */
    public function __construct(EloquentBlogRepository $repository)
    {

        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $view = [
            'categories'=>BlogCategories::all(),
            'subcategories'=>BlogSubCategories::all(),
            'blogs' => $this->repository->getBlogs(),
        ];

        return view('frontend.blogs.index',$view);
    }
    /**************************************************************************************************/

    public function show($id) {
        $view = [
        'blog' => $this->repository->getBlog($id)
        ];
        return view('frontend.blogs.show',$view);
    }

    /**************************************************************************************************/
    public function next($id) {
        $view = [
            'blog' => $this->repository->getNext($id)
        ];
        return view('frontend.blogs.show',$view);
    }
 /***************************************************************************************************/

}
