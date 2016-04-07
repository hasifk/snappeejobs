<?php

namespace App\Http\Controllers\Backend\Cms;

use App\Http\Requests\Backend\Admin\Cms\CmsRequests;
use App\Models\Cms\Cms;
use App\Repositories\Backend\Cms\EloquentCmsRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminCmsController extends Controller {

    /**
     * @var EloquentCompanyRepository
     */
    private $cmsRepository;

    /**
     * AdminCompanyController constructor.
     * @param EloquentCompanyRepository $companyRepository
     */
    public function __construct(EloquentCmsRepository $cmsRepository) {

        $this->cmsRepository = $cmsRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function listsCms() {
        $view = [
            'cms' => $this->cmsRepository->getCmsPaginated(config('jobs.default_per_page')),
        ];
        return view('backend.admin.cms.index', $view);
    }

    public function createCms() {
        return view('backend.admin.cms.create');
    }

    public function SaveCms(CmsRequests $request) {
        $user = $this->cmsRepository->save($request);
        return redirect()->route('backend.admin.cms_lists');
    }

    public function showCms($id) {
        $view = [
            'cms' => $this->cmsRepository->find($id),
        ];
        return view('backend.admin.cms.show', $view);
    }

    public function EditCms($id) {
        $view = [
            'cms' => $this->cmsRepository->find($id),
        ];
        return view('backend.admin.cms.edit', $view);
    }

    public function DeleteCms($id) {
        $this->cmsRepository->delete($id);
        //Cms::where('id', $id)->delete();
        return redirect()->route('backend.admin.cms_lists');
    }

    public function HideCms($id) {
        $this->cmsRepository->hide($id);
        //Cms::where('id', $id)->delete();
        return redirect()->route('backend.admin.cms_lists');
    }

    public function PublishCms($id) {
        $this->cmsRepository->publish($id);
        //Cms::where('id', $id)->delete();
        return redirect()->route('backend.admin.cms_lists');
    }

    public function articleCms() {
        $view = [
            'cms' => $this->cmsRepository->article(),
        ];
     return view('backend.admin.cms.index', $view);
    }

    public function blogCms() {
        $view = [
            'cms' => $this->cmsRepository->blog(),
        ];
       return view('backend.admin.cms.index', $view);
    }

}
