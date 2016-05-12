<?php namespace App\Repositories\Frontend\Blogs;

use App\Events\Frontend\Job\JobApplied;
use App\Models\Access\User\JobVisitor;
use App\Models\Access\User\User;
use App\Models\Job\Job;
use App\Models\JobSeeker\JobSeeker;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use GeoIP;

/**
 * Class EloquentUserRepository
 * @package App\Repositories\User
 */
class EloquentBlogRepository
{
    public function save($request)
    {
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
}