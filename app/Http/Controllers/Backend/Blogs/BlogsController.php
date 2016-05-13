<?php

namespace App\Http\Controllers\Backend\Blogs;

use App\Models\Access\User\User;
use App\Models\Blogs\BlogCategories;
use App\Models\Blogs\BlogSubCategories;
use App\Models\JobSeeker\JobSeeker;
use App\Repositories\Backend\Blogs\EloquentBlogRepository;
use App\Repositories\Frontend\JobSeeker\EloquentJobSeekerRepository;
use Carbon\Carbon;
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
     * JobSeekerController constructor.
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
            'blogs' => $this->repository->getBlogs(),
        ];

        return view('backend.blogs.index',$view);
    }

    public function editBlog(Request $request, $id){

        $blog = $this->repository->getBlog($id);

        $view = [
            'blog' => $blog,
            'categories' => BlogCategories::all(),
            'sub_categories' => BlogSubCategories::all()
        ];
        return view('backend.blogs.edit',$view);
    }
    
 /**************************************************************************************************/
  public function createBlog()
  {
      $view = [
          'categories' => BlogCategories::all(),
          'sub_categories' => BlogSubCategories::all(),
      ];
      return view('backend.blogs.create',$view);
  }
    /**************************************************************************************************/
    public function SaveBlog(Requests\Backend\Blogs\BlogRequest $request) {

        $this->repository->save($request);
        return redirect()->route('blogs.manageblogs');
    }
    /**************************************************************************************************/
    public function showCms($id) {

    }
}
