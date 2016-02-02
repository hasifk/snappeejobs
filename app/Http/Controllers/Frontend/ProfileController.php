<?php namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\Access\PreferencesSaveRequest;
use App\Http\Requests\Frontend\Access\ResumeUploadRequest;
use App\Repositories\Frontend\User\UserContract;
use App\Http\Requests\Frontend\User\UpdateProfileRequest;
use Carbon\Carbon;
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

	public function resumeUpload(ResumeUploadRequest $request){

		$resume = $request->file('file');

		if ( $resume && $resume->isValid() ) {

            $filePath = "users/" . auth()->user()->id."/resume/";

            Storage::deleteDirectory($filePath);

			Storage::put($filePath. $resume->getClientOriginalName() , file_get_contents($resume));

			$update_array = [
                'user_id'               => auth()->user()->id,
				'resume_filename'       => pathinfo($resume->getClientOriginalName(), PATHINFO_FILENAME),
				'resume_extension'      => $resume->getClientOriginalExtension(),
				'resume_path'           => $filePath,
				'has_resume'			=> true
			];

            \DB::table('job_seeker_details')->where('user_id', auth()->user()->id)->update([
				'resume_filename'		=> '',
				'resume_extension'		=> '',
				'resume_path'			=> ''
			]);

			if ( \DB::table('job_seeker_details')->where('user_id', auth()->user()->id)->count() ) {
				\DB::table('job_seeker_details')->where('user_id', auth()->user()->id)->update($update_array);
			} else {
				\DB::table('job_seeker_details')->insert($update_array);
			}

            return response()->json(['status' => 1]);
		}

	}

	public function savePreferences(PreferencesSaveRequest $request){

		$job_categories = $request->get('job_categories');

		foreach ($job_categories as $job_category) {
			\DB::table('category_preferences_job_seeker')->insert([
				'user_id'				=> auth()->user()->id,
				'job_category_id'		=> $job_category,
				'created_at'			=> Carbon::now(),
				'updated_at'			=> Carbon::now(),
			]);
		}

		$skills = $request->get('skills');

		foreach ($skills as $skill) {
			\DB::table('skills_job_seeker')->insert([
				'user_id'		=> auth()->user()->id,
				'skill_id'		=> $skill,
                'created_at'			=> Carbon::now(),
                'updated_at'			=> Carbon::now(),
			]);
		}

		\DB::table('job_seeker_details')->where('user_id', auth()->user()->id)->update(['preferences_saved'=> true]);

		return response()->json(['status' => 1]);
	}

}
