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
                        ->paginate(3);
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
        if (!empty($request->img)):
            $avatar = $request->img;
            if ($avatar->isValid()) {
                $filePath = "cms/" . $userid . '/';
                $extension = $avatar->getClientOriginalExtension(); // getting image extension

                $fileName = rand(11111, 99999) . '.' . $extension; // rename image

                Storage::put($filePath . $fileName, file_get_contents($avatar));
                Storage::setVisibility($filePath . $fileName, 'public');

                $obj->img = $filePath . $fileName;
            }
        endif;

        $obj->content = $request->content;
        $obj->type = $request->type;

        $obj->save();
        
    }

    public function find($id) {
        return Cms::find($id);
    }

    public function delete($id) {
        $obj = $this->find($id);
        if(!empty($obj->img)):
        Storage::delete($obj->img);
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
        return Cms::where('type', 'Article')->where('user_id', $userid)->get();
    }

    public function blog() {
        $userid = Auth::user()->id;
        return Cms::where('type', 'Blog')->where('user_id', $userid)->get();
    }

}
