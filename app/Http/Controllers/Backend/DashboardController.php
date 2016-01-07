<?php namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use \Illuminate\Http\Request;
use App\Http\Requests\Backend\AdminProfileEditRequest;
use Storage;
use DB;

/**
 * Class DashboardController
 * @package App\Http\Controllers\Backend
 */
class DashboardController extends Controller {

	/**
	 * @return \Illuminate\View\View
	 */
    public function index()
    {

        $view = [
            'employer_count'        => 2,
            'active_subscriptions'  => 2,
            'blocked_users'         => 2,
            'active_job_listings'   => 2,
        ];

        return view('backend.dashboard', $view);
    }

	public function profile()
	{
        $user = auth()->user();
        $countries = DB::table('countries')->select(['id', 'name'])->get();
        if ( auth()->user()->country_id ) {
            $states = DB::table('states')->where('country_id', auth()->user()->country_id)->select(['id', 'name'])->get();
        } else {
            $states = DB::table('states')->where('country_id', 222)->select(['id', 'name'])->get();
        }
        $data = [
            'user'      => $user,
            'countries' => $countries,
            'states'    => $states
        ];
		return view('backend.profile', $data);
	}

    public function editProfile(AdminProfileEditRequest $request)
    {

        $avatar = $request->file('avatar');

        $update_array = [
            'name'          => $request->get('name'),
            'about_me'      => $request->get('about_me'),
            'country_id'    => $request->get('country_id'),
            'state_id'      => $request->get('state_id'),
        ];

        if ( $avatar && $avatar->isValid() ) {
            
            $filePath = "users/" . auth()->user()->id."/avatar/";
            Storage::put($filePath. $avatar->getClientOriginalName() , file_get_contents($avatar));
            Storage::setVisibility($filePath. $avatar->getClientOriginalName(), 'public');

            if ( auth()->user()->avatar_filename ) {
                Storage::delete(auth()->user()->avatar_path.auth()->user()->avatar_filename.'.'.auth()->user()->avatar_extension);
            }

            $update_array = array_merge($update_array, [
                'avatar_filename' => pathinfo($avatar->getClientOriginalName(), PATHINFO_FILENAME),
                'avatar_extension' => $avatar->getClientOriginalExtension(),
                'avatar_path' => $filePath
            ]);
        }

        if ( $request->get('password') ) {
            $update_array = array_merge($update_array, ['password' => bcrypt($request->get('password'))]);
        }

        auth()->user()->update($update_array);

        return redirect()->route('backend.profile')->withFlashSuccess(trans("alerts.users.profile_updated"));

    }

}