<?php

namespace App\Repositories\Backend\Cms;

use App\Models\Cms\Cms;
use Illuminate\Http\Request;
use Auth;
use Storage;

class EloquentCmsRepository {

    public function getCmsPaginated() {
        $userid = Auth::user()->id;
        return Cms::where('user_id', $userid)->orderBy('cms.id', 'desc')
                        ->paginate(10);
    }

    public function save($request) {
        $userid = Auth::user()->id;

        if ($request->has('id'))
            $obj = $this->find($request->id);
        else {
            $obj = new Cms;
            $obj->user_id = $userid;
        }
        $obj->header = $request->heading;

        $obj->content = $request->content;
        $obj->type = $request->type;

        $obj->save();
        $obj->attachCMSImage($request->img);
        
    }

    public function find($id) {
        return Cms::find($id);
    }

    public function delete($id) {
        $obj = $this->find($id);
        if($obj):
            $obj->detachCMSImage();
        endif;
        Cms::where('id', $id)->delete();
    }

    public function hide($id) {
        $obj = $this->find($id);
        $obj->published = 0;
        $obj->save();
    }

    public function publish($id) {
        $obj = $this->find($id);
        $obj->published = 1;
        $obj->save();
    }

    public function article() {
        $userid = Auth::user()->id;
        return Cms::where('type', 'Article')->where('user_id', $userid)->paginate(10);
    }

    public function blog() {
        $userid = Auth::user()->id;
        return Cms::where('type', 'Blog')->where('user_id', $userid)->paginate(10);
    }

}
