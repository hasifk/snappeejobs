<?php

namespace App\Repositories\Backend\Newsfeed;

use App\Events\Backend\NewsFeed\NewsFeedCreated;
use App\Events\Backend\NewsFeed\NewsFeedUpdated;
use App\Models\Newsfeed\Newsfeed;
use Illuminate\Http\Request;
use Auth;
use Event;

class EloquentNewsfeedRepository {

    public function getNewsfeedsPaginated($per_page, $order_by = 'newsfeeds.id', $sort = 'desc') {
        return Newsfeed::orderBy($order_by, $sort)
                        ->paginate($per_page);
    }

    public function save($request) {
        $userid = Auth::user()->id;
       
        if ($request->has('id'))
        {
            $obj = Newsfeed::find($request->id);
            $obj->news = $request->newsfeed;
            $obj->save();

        }
        else 
        {
        $obj = new Newsfeed;
        $obj->user_id = $userid;
            $obj->news = $request->newsfeed;
            $obj->save();
            Event::fire(new NewsFeedCreated($obj, auth()->user() ));
            return 'true';
        }

    }

    public function edit($id) {
        return Newsfeed::find($id);
    }
    public function delete($id) {
       Newsfeed::where('id', $id)->delete();
    }
    

}
