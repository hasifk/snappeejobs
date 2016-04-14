<?php

namespace App\Http\Controllers\Backend\Cms;

use App\Http\Requests\Backend\Admin\Cms\CmsRequests;
use App\Models\Cms\Cms;
use App\Repositories\Backend\Cms\EloquentCmsRepository;
use App\Repositories\Backend\Logs\LogsActivitysRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Activity;

class AdminCmsController extends Controller {

    /**
     * @var EloquentCompanyRepository
     */
    private $cmsRepository;

    /**
     * AdminCompanyController constructor.
     * @param EloquentCompanyRepository $companyRepository
     */
    public function __construct(EloquentCmsRepository $cmsRepository, LogsActivitysRepository $userlogs) {

        $this->cmsRepository = $cmsRepository;
        $this->userlogs = $userlogs;
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
        $array['type'] = $request->type;
        $array['heading']='Heading of "'.substr($request->heading,0,40).'..."';
        if ($request->has('id')):
            $array['event'] = 'updated';

            $name = $this->userlogs->getActivityDescriptionForEvent($array);
        else:
            $array['event'] = 'created';

            $name = $this->userlogs->getActivityDescriptionForEvent($array);
        endif;
        Activity::log($name);
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
        $obj = $this->cmsRepository->find($id);
        $array['type'] = $obj->type;
        $array['event'] = 'deleted';
        $array['heading']='Heading of "'.substr($obj->header,0,40).'..."';
        
        $name = $this->userlogs->getActivityDescriptionForEvent($array);
        Activity::log($name);

        $this->cmsRepository->delete($id);
        return redirect()->route('backend.admin.cms_lists');
    }

    public function HideCms($id) {
        $obj = $this->cmsRepository->find($id);
        $array['type'] = $obj->type;
        $array['event'] = 'hide';
         $array['heading']='Heading of "'.substr($obj->header,0,40).'..."';
        $name = $this->userlogs->getActivityDescriptionForEvent($array);
        Activity::log($name);

        $this->cmsRepository->hide($id);
        //Cms::where('id', $id)->delete();
        return redirect()->route('backend.admin.cms_lists');
    }

    public function PublishCms($id) {
        $obj = $this->cmsRepository->find($id);
        $array['type'] = $obj->type;
        $array['event'] = 'published';
        $array['heading']='Heading of "'.substr($obj->header,0,40).'..."';
        $name = $this->userlogs->getActivityDescriptionForEvent($array);
        Activity::log($name);

        $this->cmsRepository->publish($id);
        
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
