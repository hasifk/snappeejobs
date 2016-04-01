<?php

namespace App\Http\Controllers\Backend\Newsfeed;

use App\Http\Requests\Backend\Admin\Newsfeed\NewsfeedRequests;
use App\Models\Newsfeed\Newsfeed;
use App\Repositories\Backend\Newsfeed\EloquentNewsfeedRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminNewsfeedController extends Controller {

    /**
     * @var EloquentCompanyRepository
     */
    private $newsfeedRepository;

    /**
     * AdminCompanyController constructor.
     * @param EloquentCompanyRepository $companyRepository
     */
    public function __construct(EloquentNewsfeedRepository $newsfeedRepository) {

        $this->newsfeedRepository = $newsfeedRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showNewsfeeds() {
        $view = [
            'newsfeeds' => $this->newsfeedRepository->getNewsfeedsPaginated(config('jobs.default_per_page')),
        ];
        return view('backend.admin.newsfeed.index', $view);
    }
    public function createNewsfeed() {
        return view('backend.admin.newsfeed.create');
    }
    public function SaveNewsfeed(NewsfeedRequests $request)
    {
        $user = $this->newsfeedRepository->save($request);
        return redirect()->route('backend.admin.newsfeeds');
    }
    public function showNewsfeed($id)
    {
        $view = [
            'newsfeed' => $this->newsfeedRepository->edit($id),
        ];
        return view('backend.admin.newsfeed.show',$view);
    }
    public function EditNewsfeed($id)
    {
        $view = [
            'newsfeed' => $this->newsfeedRepository->edit($id),
        ];
        return view('backend.admin.newsfeed.edit',$view);
    }
    public function DeleteNewsfeed($id)
    {
        Newsfeed::where('id', $id)->delete();
        return redirect()->route('backend.admin.newsfeeds');
    }
}