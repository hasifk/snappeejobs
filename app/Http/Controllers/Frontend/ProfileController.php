<?php namespace App\Http\Controllers\Frontend;

use App\Events\Backend\Mail\EmployerChatReceived;
use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\Access\PreferencesSaveRequest;
use App\Http\Requests\Frontend\Access\ProfileImagesUploadRequest;
use App\Http\Requests\Frontend\Access\ProfileVideoUploadRequest;
use App\Http\Requests\Frontend\Access\ResumeUploadRequest;
use App\Http\Requests\Frontend\JobSeeker\JobSeekerVideoLinkRequest;
use App\Http\Requests\Frontend\User\JobSeekerReplyMessage;
use App\Models\Access\User\User;
use App\Models\JobSeeker\JobSeeker;
use App\Models\Mail\Thread;
use App\Repositories\Backend\JobSeeker\EloquentJobSeekerRepository;
use App\Repositories\Backend\Logs\LogsActivitysRepository;
use App\Repositories\Backend\Mail\EloquentMailRepository;
use App\Repositories\Frontend\User\UserContract;
use App\Http\Requests\Frontend\User\UpdateProfileRequest;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Storage;
use Auth;
use Activity;

/**
 * Class ProfileController
 * @package App\Http\Controllers\Frontend
 */
class ProfileController extends Controller {
	/**
	 * @var UserContract
	 */
	private $users;
    private $userLogs;

	/**
	 * ProfileController constructor.
	 * @param UserContract $users
     */
	public function __construct(UserContract $users,EloquentJobSeekerRepository $videorepo,LogsActivitysRepository $userLogs)
	{

		$this->users = $users;
        $this->videorepo =$videorepo;
		$this->userLogs =$userLogs;
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

		return view('frontend.user.profile.edit' . ( env('APP_DESIGN') == 'new' ? 'new' : "" ), $data);
	}

	public function editResume(){
		$array['type'] = 'Resume';
		$array['heading']='';
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

        $array['event'] = 'updated';

        $name = $this->userLogs->getActivityDescriptionForEvent($array);
        Activity::log($name);
		return view('frontend.user.resume.edit' . ( env('APP_DESIGN') == 'new' ? 'new' : "" ), [
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

		return view('frontend.user.preferences.edit' . ( env('APP_DESIGN') == 'new' ? 'new' : "" ), [
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

        $array['type'] = 'Profile';
        $array['heading']='';
		$user->updateProfile($request->all());

		$avatar = $request->file('avatar');

		if ( $avatar && $avatar->isValid() ) {

			$filePath = "users/" . auth()->user()->id."/avatar/";
			\Storage::put($filePath. $avatar->getClientOriginalName() , file_get_contents($avatar));
			\Storage::setVisibility($filePath. $avatar->getClientOriginalName(), 'public');

			if ( auth()->user()->avatar_filename ) {
				foreach (config('image.thumbnails.user_profile_image') as $image) {
					if ( \Storage::has($filePath.auth()->user()->avatar_filename.$image['width'].'x'.$image['height'].'.'.auth()->user()->avatar_extension) ) {
						\Storage::delete($filePath.auth()->user()->avatar_filename.$image['width'].'x'.$image['height'].'.'.auth()->user()->avatar_extension);
					}
				}
				if ( \Storage::has($filePath.auth()->user()->avatar_filename.'.'.auth()->user()->avatar_extension) ) {
					\Storage::delete($filePath.auth()->user()->avatar_filename.'.'.auth()->user()->avatar_extension);
				}
			}

			$update_array = [
				'avatar_filename' => pathinfo($avatar->getClientOriginalName(), PATHINFO_FILENAME),
				'avatar_extension' => $avatar->getClientOriginalExtension(),
				'avatar_path' => $filePath
			];

			auth()->user()->update($update_array);

			// Resize User Profile Image
			$profile_image = \Image::make($avatar);

			\Storage::disk('local')->put($filePath.$avatar->getClientOriginalName(), file_get_contents($avatar));

			foreach (config('image.thumbnails.user_profile_image') as $image) {
				$profile_image->resize($image['width'], $image['height'])->save( storage_path('app/' .$filePath.pathinfo($avatar->getClientOriginalName(), PATHINFO_FILENAME).$image['width'].'x'.$image['height'].'.'.$avatar->getClientOriginalExtension() ) );
				\Storage::put($filePath.pathinfo($avatar->getClientOriginalName(), PATHINFO_FILENAME).$image['width'].'x'.$image['height'].'.'.$avatar->getClientOriginalExtension() , file_get_contents( storage_path('app/' .$filePath.pathinfo($avatar->getClientOriginalName(), PATHINFO_FILENAME).$image['width'].'x'.$image['height'].'.'.$avatar->getClientOriginalExtension() ) ) );
				\Storage::setVisibility($filePath.pathinfo($avatar->getClientOriginalName(), PATHINFO_FILENAME).$image['width'].'x'.$image['height'].'.'.$avatar->getClientOriginalExtension(), 'public');
			}

			\Storage::disk('local')->deleteDirectory($filePath);

			$this->users->updateProfileCompleteness(auth()->user());

            $array['event'] = 'updated';

            $name = $this->userLogs->getActivityDescriptionForEvent($array);
            Activity::log($name);
		}

		return redirect()->route('frontend.dashboard')->withFlashSuccess(trans("strings.profile_successfully_updated"));
	}

	public function updateProfileImage(Request $request) {

        $array['type'] = 'Profile Image';
        $array['heading']='';
		$avatar = $request->file('file');

		if ( $avatar && $avatar->isValid() ) {

			$filePath = "users/" . auth()->user()->id."/avatar/";
			\Storage::put($filePath. $avatar->getClientOriginalName() , file_get_contents($avatar));
			\Storage::setVisibility($filePath. $avatar->getClientOriginalName(), 'public');

			if ( auth()->user()->avatar_filename ) {
				foreach (config('image.thumbnails.user_profile_image') as $image) {
					if ( \Storage::has($filePath.auth()->user()->avatar_filename.$image['width'].'x'.$image['height'].'.'.auth()->user()->avatar_extension) ) {
						\Storage::delete($filePath.auth()->user()->avatar_filename.$image['width'].'x'.$image['height'].'.'.auth()->user()->avatar_extension);
					}
				}
				if ( \Storage::has($filePath.auth()->user()->avatar_filename.'.'.auth()->user()->avatar_extension) ) {
					\Storage::delete($filePath.auth()->user()->avatar_filename.'.'.auth()->user()->avatar_extension);
				}
			}

			$update_array = [
				'avatar_filename' => pathinfo($avatar->getClientOriginalName(), PATHINFO_FILENAME),
				'avatar_extension' => $avatar->getClientOriginalExtension(),
				'avatar_path' => $filePath
			];

			auth()->user()->update($update_array);

			// Resize User Profile Image
			$profile_image = \Image::make($avatar);

			\Storage::disk('local')->put($filePath.$avatar->getClientOriginalName(), file_get_contents($avatar));

			foreach (config('image.thumbnails.user_profile_image') as $image) {
				$profile_image->resize($image['width'], $image['height'])->save( storage_path('app/' .$filePath.pathinfo($avatar->getClientOriginalName(), PATHINFO_FILENAME).$image['width'].'x'.$image['height'].'.'.$avatar->getClientOriginalExtension() ) );
				\Storage::put($filePath.pathinfo($avatar->getClientOriginalName(), PATHINFO_FILENAME).$image['width'].'x'.$image['height'].'.'.$avatar->getClientOriginalExtension() , file_get_contents( storage_path('app/' .$filePath.pathinfo($avatar->getClientOriginalName(), PATHINFO_FILENAME).$image['width'].'x'.$image['height'].'.'.$avatar->getClientOriginalExtension() ) ) );
				\Storage::setVisibility($filePath.pathinfo($avatar->getClientOriginalName(), PATHINFO_FILENAME).$image['width'].'x'.$image['height'].'.'.$avatar->getClientOriginalExtension(), 'public');
			}

			\Storage::disk('local')->deleteDirectory($filePath);

			$this->users->updateProfileCompleteness(auth()->user());

            $array['event'] = 'updated';
            $name = $this->userLogs->getActivityDescriptionForEvent($array);
            Activity::log($name);
		}

		return response()->json(['status' => 1]);
	}

	public function resumeUpload(ResumeUploadRequest $request){
        $array['type'] = 'Resume';
        $array['heading']='has been Uploaded';
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

            $array['event'] = 'uploaded';
            $name = $this->userLogs->getActivityDescriptionForEvent($array);
            Activity::log($name);
            return response()->json(['status' => 1]);
		}

	}

	public function savePreferences(PreferencesSaveRequest $request){

		$industries = $request->get('industries');
        $array['type'] = 'Preferences';
        $array['heading']='auth()->user()->name';
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
        $array['event'] = 'created';
        $name = $this->userLogs->getActivityDescriptionForEvent($array);
        Activity::log($name);
		return response()->json(['status' => 1]);
	}

	public function saveEmployerPreferences(PreferencesSaveRequest $request){

        $array['type'] = 'Employer Preferences';
        $array['heading']='';
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
        $array['event'] = 'updated';
        $name = $this->userLogs->getActivityDescriptionForEvent($array);
        Activity::log($name);
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

		$companies = \DB::table('follow_companies')
			->join('companies', 'companies.id', '=', 'follow_companies.company_id')
			->where('follow_companies.user_id', auth()->user()->id)
			->select([
				'companies.url_slug',
				'companies.title'
			])
			->get();

		return view('frontend.user.profile.favourites' . ( env('APP_DESIGN') == 'new' ? 'new' : "" ), [
			'companies' => $companies,
			'jobs' 		=> $jobs
		]);

	}

	public function videos(){
		$jobSeeker = auth()->user()->jobseeker_details;
		$jobSeekerObj = JobSeeker::findOrNew($jobSeeker->id);
		$jobSeekerVideo = $jobSeekerObj->videos()->first();
        $videoLink = $jobSeekerObj->videoLink()->first();
		return view('frontend.user.profile.videos' . ( env('APP_DESIGN') == 'new' ? 'new' : "" ), [ 'video' => $jobSeekerVideo,'videolink' => $videoLink ]);
	}

	public function uploadVideos(ProfileVideoUploadRequest $request){

        $array['type'] = 'Video';
        $array['heading']='has been Uploaded';
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
        $array['event'] = 'uploaded';
        $name = $this->userLogs->getActivityDescriptionForEvent($array);
        Activity::log($name);
		return response()->json(['status' => 1]);
	}
/***************************************************************************************************************/
	public function storeVideoLinks(JobSeekerVideoLinkRequest $request){
        $array['type'] = 'Video Link';
        $array['heading']='has been Uploaded';
      if($videolink=$this->videorepo->storeJobSeekerVideoLink($request->videolink)):
          $array['event'] = 'uploaded';
          $name = $this->userLogs->getActivityDescriptionForEvent($array);
          Activity::log($name);
        $request->session()->flash('success', $videolink);
        else:
        $request->session()->flash('failure','Failed to Store VideoLink.Please try again. ') ;
        endif;

        return back();
	}
/**************************************************************************************************************/
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

		return view('frontend.user.profile.images' . ( env('APP_DESIGN') == 'new' ? 'new' : "" ));
	}

	public function uploadImages(ProfileImagesUploadRequest $request){
        $array['type'] = 'Image';
        $array['heading']='has been Uploaded';

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

			// Resize User Profile Image
			$profile_image = \Image::make($avatar);

			\Storage::disk('local')->put($filePath.$avatar->getClientOriginalName(), file_get_contents($avatar));

			foreach (config('image.thumbnails.jobseeker_images') as $image) {
				$profile_image->resize($image['width'], $image['height'])->save( storage_path('app/' .$filePath.pathinfo($avatar->getClientOriginalName(), PATHINFO_FILENAME).$image['width'].'x'.$image['height'].'.'.$avatar->getClientOriginalExtension() ) );
				\Storage::put($filePath.pathinfo($avatar->getClientOriginalName(), PATHINFO_FILENAME).$image['width'].'x'.$image['height'].'.'.$avatar->getClientOriginalExtension() , file_get_contents( storage_path('app/' .$filePath.pathinfo($avatar->getClientOriginalName(), PATHINFO_FILENAME).$image['width'].'x'.$image['height'].'.'.$avatar->getClientOriginalExtension() ) ) );
				\Storage::setVisibility($filePath.pathinfo($avatar->getClientOriginalName(), PATHINFO_FILENAME).$image['width'].'x'.$image['height'].'.'.$avatar->getClientOriginalExtension(), 'public');
			}

			\Storage::disk('local')->deleteDirectory($filePath);

			$this->users->updateProfileCompleteness(auth()->user());

            $array['event'] = 'uploaded';
            $name = $this->userLogs->getActivityDescriptionForEvent($array);
            Activity::log($name);

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
		return view('frontend.user.profile.socialmedia' . ( env('APP_DESIGN') == 'new' ? 'new' : "" ));
	}

	public function unreadchats(){
		$unread_messages = \DB::table('thread_participants')
			->join('threads', 'thread_participants.thread_id', '=', 'threads.id')
			->join('users', 'thread_participants.sender_id', '=', 'users.id')
			->whereNull('thread_participants.deleted_at')
			->whereNull('thread_participants.read_at')
			->where('thread_participants.user_id', auth()->user()->id)
			->orderBy('thread_participants.updated_at')
			->select([
				'users.name',
				'users.id',
				'threads.subject',
				'threads.last_message',
				'threads.message_count',
				'threads.created_at',
				'threads.updated_at',
				'thread_participants.thread_id',
				'thread_participants.read_at',
			])
			->orderBy('threads.updated_at', 'desc')
			->get();

		if ( $unread_messages ) {
			foreach ($unread_messages as $key => $unread_message) {
				$unread_messages[$key]->{'last_message'} = str_limit($unread_message->last_message, 30);
				$unread_messages[$key]->{'image'} = User::find($unread_message->id)->getPictureAttribute(25, 25);
				$unread_messages[$key]->{'was_created'} = Carbon::parse($unread_message->created_at)->diffForHumans();
			}
		}

		return response()->json($unread_messages);
	}

	public function rejected_applications(){
		$rejected_applications = \DB::table('job_applications')
			->whereNull('job_applications.declined_viewed_at')
			->whereNotNull('job_applications.declined_at')
			->where('job_applications.user_id', auth()->user()->id)
			->orderBy('job_applications.updated_at')
			->select([
				'job_applications.id',
				'job_applications.job_id',
				'job_applications.declined_at',
				'job_applications.declined_by'
			])
			->orderBy('job_applications.updated_at', 'desc')
			->get();

		if ( $rejected_applications ) {
			foreach ($rejected_applications as $key => $rejected_application) {
				$company_id = \DB::table('jobs')->where('id', $rejected_application->job_id)->value('company_id');
				$company_title = \DB::table('companies')->where('id', $company_id)->value('title');
				$rejected_applications[$key]->{'message'} = $company_title." rejected your application";
				$rejected_applications[$key]->{'image'} = User::find($rejected_application->declined_by)->getPictureAttribute(25, 25);
				$rejected_applications[$key]->{'was_created'} = Carbon::parse($rejected_application->declined_at)->diffForHumans();
			}
		}

		return response()->json($rejected_applications);
	}

	public function rejected_applications_mark_read(){
		\DB::table('job_applications')
			->whereNull('job_applications.declined_viewed_at')
			->whereNotNull('job_applications.declined_at')
			->where('job_applications.user_id', auth()->user()->id)
			->update([
				'declined_viewed_at' => Carbon::now()
			]);

		return response()->json(['status' => 1]);
	}
	
	public function messages(EloquentMailRepository $mailRepository){
	    $messages = $mailRepository->inbox(10);
		return view('frontend.user.mail.inbox', ['inbox' => $messages]);
	}

	public function viewThread(EloquentMailRepository $mailRepository, $id){
	    $thread = $mailRepository->getThread($id);
		return view('frontend.user.mail.show', [ 'thread' => $thread ]);
	}

	public function replyThread(JobSeekerReplyMessage $request, EloquentMailRepository $mailRepository, $thread_id){
		$mailRepository->sendReply($request, $thread_id);

		$thread = Thread::find($thread_id);

		if ( $thread->application_id ) {
			event(new EmployerChatReceived($thread->id));
		}

		return redirect()
			->route('frontend.message', $thread_id)
			->withFlashSuccess('Successfully sent the reply');
	}

}
