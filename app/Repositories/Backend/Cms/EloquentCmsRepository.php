<?php

namespace App\Repositories\Backend\Cms;

use App\Models\Cms\Cms;
use Illuminate\Http\Request;
use Auth;

class EloquentCmsRepository {

    public function getCmsPaginated($per_page, $order_by = 'cms.id', $sort = 'desc') {
        return Cms::orderBy($order_by, $sort)
                        ->paginate($per_page);
    }

    public function save($request) {
        $userid = Auth::user()->id;

        if ($request->has('id'))
            $obj = Cms::find($request->id);
        else {
            $obj = new Cms;
            $obj->user_id = $userid;
        }
        $obj->header = $request->heading;
        if (!empty($request->img)):
            if ($request->img->isValid()) {
                $destinationPath = 'assets/clientassets/uploads/' . $userid . '/Gallery'; // upload path
                $extension = $request->img->getClientOriginalExtension(); // getting image extension
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0777, true);
                }
                $fileName = rand(11111, 99999) . '.' . $extension; // rename image

                $request->img->move($destinationPath, $fileName); // uploading file to given path
                // sending back with message
                $obj->img = $destinationPath . '/' . $fileName;
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
        Cms::where('id', $id)->delete();
    }

    public function hide($id) {
        $obj = Cms::find($id);
        $obj->published = 0;
        $obj->save();
    }

    public function publish($id) {
        $obj = Cms::find($id);
        $obj->published = 1;
        $obj->save();
    }

    public function articles($id) {
        return Cms::where('type', 'Article')->get();
    }

}
