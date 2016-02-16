<?php namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\Access\PreferencesSaveRequest;
use App\Http\Requests\Frontend\Access\ProfileImagesUploadRequest;
use App\Http\Requests\Frontend\Access\ProfileVideoUploadRequest;
use App\Http\Requests\Frontend\Access\ResumeUploadRequest;
use App\Models\JobSeeker\JobSeeker;
use App\Repositories\Frontend\User\UserContract;
use App\Http\Requests\Frontend\User\UpdateProfileRequest;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Storage;

/**
 * Class ProfileController
 * @package App\Http\Controllers\Frontend
 */
class ProfileController extends Controller {
	/**
	 * @var UserContract
	 */
	private $users;


	/**
	 * ProfileController constructor.
	 * @param UserContract $users
     */
	public function __construct(UserContract $users)
	{

		$this->users = $users;
	}

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

	public function editResume(){

		$job_seeker_details = auth()->user()->jobseeker_details;

		$resume_link = '';

		if ( is_null($job_seeker_details) ) {
			$job_seeker = false;
		} else {
			$job_seeker = $job_seeker_details;
			if ( $job_seeker_details->has_resume ) {
				$resume_link = $this->getFileUrl($job_seeker_details->resume_path.$job_seeker_details->resume_filename.'.'.$job_seeker_details->resume_extension);
			}
		}

		return view('frontend.user.resume.edit', [
			'job_seeker' 	=> $job_seeker,
			'resume_link'	=> $resume_link
		]);
	}

	public function editPreferences(){

		$job_seeker_details = JobSeeker::findOrFail(auth()->user()->jobseeker_details->id);

		$job_seeker = false;
		if ( !is_null($job_seeker_details) ) {
			$job_seeker = $job_seeker_details;
		}

		$skills = \DB::table('skills')->select(['id', 'name'])->get();
		$job_categories = \DB::table('job_categories')->select(['id', 'name'])->get();
		$industries = \DB::table('industries')->select(['id', 'name'])->get();

		return view('frontend.user.preferences.edit', [
			'skills' 			=> $skills,
			'job_categories'	=> $job_categories,
			'industries'		=> $industries,
			'job_seeker'		=> $job_seeker
		]);
	}

	private function getFileUrl($key) {
		$s3 = \Storage::disk('s3');
		$client = $s3->getDriver()->getAdapter()->getClient();
		$bucket = config('filesystems.disks.s3.bucket');

		$command = $client->getCommand('GetObject', [
			'Bucket' => $bucket,
			'Key' => $key
		]);

		$request = $client->createPresignedRequest($command, '+1 minutes');

		return (string) $request->getUri();
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

			$this->users->updateProfileCompleteness(auth()->user());
        }

		return redirect()->route('frontend.dashboard')->withFlashSuccess(trans("strings.profile_successfully_updated"));
	}

	public function updateProfileImage(Request $request) {

		$avatar = $request->file('file');

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
			$this->users->updateProfileCompleteness(auth()->user());
		}

		return response()->json(['status' => 1]);
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

			$this->users->updateProfileCompleteness(auth()->user());

            return response()->json(['status' => 1]);
		}

	}

	public function savePreferences(PreferencesSaveRequest $request){

		$industries = $request->get('industries');

		foreach ($industries as $industry) {
			\DB::table('job_seeker_industry_preferences')->insert([
				'user_id'				=> auth()->user()->jobseeker_details->id,
				'industry_id'			=> $industry,
				'created_at'			=> Carbon::now(),
				'updated_at'			=> Carbon::now(),
			]);
		}

		$job_categories = $request->get('job_categories');

		foreach ($job_categories as $job_category) {
			\DB::table('category_preferences_job_seeker')->insert([
				'user_id'				=> auth()->user()->jobseeker_details->id,
				'job_category_id'		=> $job_category,
				'created_at'			=> Carbon::now(),
				'updated_at'			=> Carbon::now(),
			]);
		}

		$skills = $request->get('skills');

		foreach ($skills as $skill) {
			\DB::table('skills_job_seeker')->insert([
				'user_id'				=> auth()->user()->jobseeker_details->id,
				'skill_id'				=> $skill,
                'created_at'			=> Carbon::now(),
                'updated_at'			=> Carbon::now(),
			]);
		}

		\DB::table('job_seeker_details')->where('user_id', auth()->user()->id)->update([
			'preferences_saved'=> true,
			'size'=> $request->get('size')
		]);

		$this->users->updateProfileCompleteness(auth()->user());

		return response()->json(['status' => 1]);
	}

	public function saveEmployerPreferences(PreferencesSaveRequest $request){

		$industries = $request->get('industries');

		\DB::table('job_seeker_industry_preferences')->where('user_id', auth()->user()->jobseeker_details->id)->delete();

		foreach ($industries as $industry) {
			\DB::table('job_seeker_industry_preferences')->insert([
				'user_id'				=> auth()->user()->jobseeker_details->id,
				'industry_id'			=> $industry,
				'created_at'			=> Carbon::now(),
				'updated_at'			=> Carbon::now(),
			]);
		}

		$job_categories = $request->get('job_categories');

		\DB::table('category_preferences_job_seeker')->where('user_id', auth()->user()->jobseeker_details->id)->delete();

		foreach ($job_categories as $job_category) {
			\DB::table('category_preferences_job_seeker')->insert([
				'user_id'				=> auth()->user()->jobseeker_details->id,
				'job_category_id'		=> $job_category,
				'created_at'			=> Carbon::now(),
				'updated_at'			=> Carbon::now(),
			]);
		}

		$skills = $request->get('skills');

		\DB::table('skills_job_seeker')->where('user_id', auth()->user()->jobseeker_details->id)->delete();

		foreach ($skills as $skill) {
			\DB::table('skills_job_seeker')->insert([
				'user_id'				=> auth()->user()->jobseeker_details->id,
				'skill_id'				=> $skill,
				'created_at'			=> Carbon::now(),
				'updated_at'			=> Carbon::now(),
			]);
		}

		\DB::table('job_seeker_details')->where('user_id', auth()->user()->id)->update([
			'preferences_saved'=> true,
			'size'=> $request->get('size')
		]);

		$this->users->updateProfileCompleteness(auth()->user());

		alert()->success('Your preferences are saved.')->autoclose(3000);

		return redirect(route('frontend.preferences.edit'));
	}

	public function resendConfirmation(Request $request){

	}

	public function favourites(){

		$jobs = \DB::table('like_jobs')
			->join('jobs', 'jobs.id', '=', 'like_jobs.job_id')
			->join('companies', 'companies.id', '=', 'jobs.company_id')
			->where('like_jobs.user_id', auth()->user()->id)
			->select([
				\DB::raw('companies.title AS company_title'),
				'companies.url_slug',
				\DB::raw('jobs.title AS job_title'),
				'jobs.title_url_slug'
			])
			->get();

		$companies = \DB::table('like_companies')
			->join('companies', 'companies.id', '=', 'like_companies.company_id')
			->where('like_companies.user_id', auth()->user()->id)
			->select([
				'companies.url_slug',
				'companies.title'
			])
			->get();

		return view('frontend.user.profile.favourites', [
			'companies' => $companies,
			'jobs' 		=> $jobs
		]);

	}

	public function videos(){
		$jobSeeker = auth()->user()->jobseeker_details;
		$jobSeekerObj = JobSeeker::findOrNew($jobSeeker->id);
		$jobSeekerVideo = $jobSeekerObj->videos()->first();
		return view('frontend.user.profile.videos', [ 'video' => $jobSeekerVideo ]);
	}

	public function uploadVideos(ProfileVideoUploadRequest $request){
		$video = $request->file('file');

		if ( $video && $video->isValid() ) {

			$filePath = "users/" . auth()->user()->id."/videos/";
			Storage::put($filePath. $video->getClientOriginalName() , file_get_contents($video));
			Storage::setVisibility($filePath. $video->getClientOriginalName(), 'public');

			$jobSeeker = auth()->user()->jobseeker_details;

			$jobSeekerObj = JobSeeker::findOrNew($jobSeeker->id);

			if ( $jobSeekerObj->videos->count() ) {
				Storage::delete(
					$jobSeekerObj->videos()->first()->path.
					$jobSeekerObj->videos->first()->filename.
					'.'.
					$jobSeekerObj->videos->first()->extension
				);
				$jobSeekerObj->videos()->delete();
			}

			$update_array = [
				'user_id' => $jobSeekerObj->id,
				'filename' => pathinfo($video->getClientOriginalName(), PATHINFO_FILENAME),
				'extension' => $video->getClientOriginalExtension(),
				'path' => $filePath
			];

			$jobSeekerObj->videos()->create($update_array);
		}

		$this->users->updateProfileCompleteness(auth()->user());

		return response()->json(['status' => 1]);
	}

	public function images(){

		$jobSeeker = auth()->user()->jobseeker_details;

		$jobSeekerObj = JobSeeker::find($jobSeeker->id);

		$images = [];

		foreach ($jobSeekerObj->images as $image) {
			$images[] = [
				'filename' 	=> $image->filename,
				'path' 		=> $image->path,
				'extension' => $image->extension,
				'image'		=> $image->image,
				'size' 		=> Storage::size($image->path.$image->filename.'.'.$image->extension)
			];
		}

		javascript()->put(['profile_images' => $images]);

		return view('frontend.user.profile.images');
	}

	public function uploadImages(ProfileImagesUploadRequest $request){

		$avatar = $request->file('file');

		if ( $avatar && $avatar->isValid() ) {

			$jobSeeker = auth()->user()->jobseeker_details;

			$jobSeekerObj = JobSeeker::find($jobSeeker->id);

			$filePath = "users/" . auth()->user()->id."/avatar/";
			Storage::put($filePath. $avatar->getClientOriginalName() , file_get_contents($avatar));
			Storage::setVisibility($filePath. $avatar->getClientOriginalName(), 'public');

			$insert_array= [
				'user_id' => $jobSeekerObj->id,
				'filename' => pathinfo($avatar->getClientOriginalName(), PATHINFO_FILENAME),
				'extension' => $avatar->getClientOriginalExtension(),
				'path' => $filePath
			];

			$result = $jobSeekerObj->images()->create($insert_array);

			$this->users->updateProfileCompleteness(auth()->user());

			return response()->json(['status' => 1]);
		}

		return response()->json(['status' => 0]);

	}

	public function deleteImage(Request $request){

		$jobSeeker = auth()->user()->jobseeker_details;

		$jobSeekerObj = JobSeeker::find($jobSeeker->id);

		$imageObject = $jobSeekerObj
			->images()
			->where('filename', $request->get('filename'))
			->where('path', $request->get('path'))
			->where('extension', $request->get('extension'));

		if ( $imageObject->count() ) {
			Storage::delete(
				$request->get('path').
				$request->get('filename').
				'.'.
				$request->get('extension')
			);
			$imageObject->delete();

			$this->users->updateProfileCompleteness(auth()->user());

			return response()->json(['status' => 1]);
		} else {
			return response()->json(['status' => 0]);
		}
	}

	public function socialmedia(){
		return view('frontend.user.profile.socialmedia');
	}

}
