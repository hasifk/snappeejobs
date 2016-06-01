<?php

namespace App\Http\Controllers\Backend\Blogs;

use App\Models\Access\User\User;
use App\Models\Blogs\BlogCategories;
use App\Models\Blogs\BlogSubCategories;
use App\Models\JobSeeker\JobSeeker;
use App\Repositories\Backend\Blogs\EloquentBlogRepository;
use App\Repositories\Frontend\JobSeeker\EloquentJobSeekerRepository;
use App\Repositories\Backend\Logs\LogsActivitysRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Activity;
use Auth;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class BlogsController extends Controller {

    /**
     * @var EloquentJobSeekerRepository
     */
    private $repository;

    /**
     * JobSeekerController constructor.
     * @param EloquentJobSeekerRepository $repository
     */
    public function __construct(EloquentBlogRepository $repository, LogsActivitysRepository $userlogs) {

        $this->repository = $repository;
        $this->userlogs = $userlogs;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {

        $view = [
            'blogs' => $this->repository->getBlogs(),
        ];

        return view('backend.blogs.index', $view);
    }

    public function editBlog(Request $request, $id) {

        $blog = $this->repository->getBlog($id);

        $view = [
            'blog' => $blog,
            'categories' => BlogCategories::all(),
            'sub_categories' => BlogSubCategories::all()
        ];
        return view('backend.blogs.edit', $view);
    }

    /*     * *********************************************************************************************** */

    public function createBlog() {
        $view = [
            'categories' => BlogCategories::all(),
            'sub_categories' => BlogSubCategories::all(),
        ];
        return view('backend.blogs.create', $view);
    }

    /*     * *********************************************************************************************** */

    public function SaveBlog(Requests\Backend\Blogs\BlogRequest $request) {


        if ($this->repository->save($request)):
            if ($request->has('id')):
                $array['event'] = 'updated';
                $array['heading'] = 'With title of  " ' . substr(strip_tags($request->title), 0, 40) . '... " by ' . Auth::user()->name;
            else:
                $array['event'] = 'created';
                $array['heading'] = 'title of  " ' . substr(strip_tags($request->title), 0, 40) . '... " by ' . Auth::user()->name;
            endif;
            $array['type'] = "Blog";
            $name = $this->userlogs->getActivityDescriptionForEvent($array);
            Activity::log($name);
        endif;

        return redirect()->route('Blogs');
    }

    /*     * *********************************************************************************************** */

    public function delete($id) {
        $blog = $this->repository->getBlog($id);
        if ($this->repository->deleteBlog($id)):

            $array['type'] = "Blog";
            $array['event'] = 'deleted';
            $array['heading'] = 'with title of  " ' . substr(strip_tags($blog->title), 0, 40) . '..."';
            $name = $this->userlogs->getActivityDescriptionForEvent($array);
            Activity::log($name);
        endif;

        return back();
    }

    /*     * *********************************************************************************************** */
}
