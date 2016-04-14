<?php

namespace App\Http\Controllers\Backend\Logs;

//use App\Http\Requests\Backend\Admin\Newsfeed\NewsfeedRequests;
use App\Models\Access\User\User;
//use App\Repositories\Backend\Newsfeed\EloquentNewsfeedRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Activitylog\Models\Activity;
use Log;
use Auth;

class AdminLogController extends Controller {

    /**
     * @var EloquentCompanyRepository
     */
    private $newsfeedRepository;

    /**
     * AdminCompanyController constructor.
     * @param EloquentCompanyRepository $companyRepository
     */
//    public function __construct(EloquentNewsfeedRepository $newsfeedRepository) {
//
//        $this->newsfeedRepository = $newsfeedRepository;
//    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLogs() {
        
        $user = Auth::user()->id;
        
        $view = [
            'user' => Activity::with('user')->latest()->limit(100)->get(),
        ];
        return view('backend.admin.logs.index', $view);
    }
}