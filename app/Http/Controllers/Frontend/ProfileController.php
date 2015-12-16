<?php namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Repositories\Frontend\User\UserContract;
use App\Http\Requests\Frontend\User\UpdateProfileRequest;
use DB;
use Storage;

/**
 * Class ProfileController
 * @package App\Http\Controllers\Frontend
 */
class ProfileController extends Controller {

	/**
	 * @return mixed
     */
	public function edit() {

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

		return view('frontend.user.profile.edit', $data);
	}

	/**
	 * @param UserContract $user
	 * @param UpdateProfileRequest $request
	 * @return mixed
	 */
	public function update(UserContract $user, UpdateProfileRequest $request) {
		$user->updateProfile($request->all());

        $avatar = $request->file('avatar');

        if ( $avatar && $avatar->isValid() ) {

            $filePath = "users/" . auth()->user()->id."/avatar/";
            Storage::put($filePath. $avatar->getClientOriginalName() , file_get_contents($avatar));
            Storage::setVisibility($filePath. $avatar->getClientOriginalName(), 'public');

            if ( auth()->user()->avatar_filename ) {
                Storage::delete(auth()->user()->avatar_path.auth()->user()->avatar_filename.'.'.auth()->user()->avatar_extension);
            }

            $update_array = [
                'avatar_filename' => pathinfo($avatar->getClientOriginalName(), PATHINFO_FILENAME),
                'avatar_extension' => $avatar->getClientOriginalExtension(),
                'avatar_path' => $filePath
            ];

            auth()->user()->update($update_array);
        }

		return redirect()->route('frontend.dashboard')->withFlashSuccess(trans("strings.profile_successfully_updated"));
	}
}