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

       /* $countries = \DB::table('countries')->select(['id', 'name'])->get();
        $skills = \DB::table('skills')->select(['id', 'name'])->get();
        $job_categories = \DB::table('job_categories')->select(['id', 'name'])->get();

        if ( request('country_id') ) {
            $states = \DB::table('states')
                ->where('country_id', request('country_id'))
                ->select(['id', 'name'])
                ->get();
        } else {
            $states = \DB::table('states')
                ->where('country_id', 222)
                ->select(['id', 'name'])
                ->get();
        }

        $jobSeekerResult = $this->repository->getJobsSeekersPaginated($request, config('jobs.default_per_page'));

        $jobSeekers = $jobSeekerResult['jobseekers'];
        $paginator = $jobSeekerResult['paginator'];

        $view = [
            'countries'         => $countries,
            'states'            => $states,
            'skills'            => $skills,
            'categories'        => $job_categories,
            'job_seekers'       => $jobSeekers,
            'paginator'         => $paginator
        ];*/

        return view('backend.blogs.index');
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
