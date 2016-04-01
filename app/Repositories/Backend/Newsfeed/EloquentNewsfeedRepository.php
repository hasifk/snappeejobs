<?php

namespace App\Repositories\Backend\Newsfeed;


use App\Models\Newsfeed\Newsfeed;
use Illuminate\Http\Request;
use Auth;

class EloquentNewsfeedRepository
{
     public function getNewsfeedsPaginated($per_page, $order_by = 'newsfeeds.id', $sort = 'desc'){
        return Newsfeed::orderBy($order_by, $sort)
            ->paginate($per_page);
    }
    public function save($request)
    {
        $userid = Auth::user()->id;
        $obj = new Newsfeed;
        $obj->user_id=$userid;
        $obj->news = $request->newsfeed;
        $obj->save();
    }
}
