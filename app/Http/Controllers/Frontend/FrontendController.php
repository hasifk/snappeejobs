<?php namespace App\Http\Controllers\Frontend;
use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\EmployerSignupRequest;
use App\Models\Job\Job;
use App\Models\JobSeeker\JobSeeker;
use App\Repositories\Frontend\Index\EloquentIndexRepository;
use App\Repositories\Frontend\User\EloquentUserRepository;
use DB;
use Illuminate\Http\Request;
/**
 * Class FrontendController
 * @package App\Http\Controllers
 */
class FrontendController extends Controller {
	/**
	 * @var EloquentUserRepository
	 */
	private $users;
	private $indexRepository;
	/**
	 * FrontendController constructor.
	 * @param EloquentUserRepository $users
	 */
	public function __construct(EloquentUserRepository $users,EloquentIndexRepository $indexRepository)
	{
		$this->users = $users;
		$this->indexRepository = $indexRepository;
	}
	/**
	 * @param \Request $request
	 * @return \Illuminate\View\View
	 * @throws \Exception
	 */
	public function index(Request $request)
	{
		javascript()->put([
			'test' => 'it works!'
		]);
		$industries = \DB::table('industries')->select(['id', 'name'])->get();
		$skills = \DB::table('skills')->select(['id', 'name'])->get();
		$job_categories = \DB::table('job_categories')->select(['id', 'name'])->get();
		$countries = \DB::table('countries')->select(['id', 'name'])->get();
		$jobs_landing=Job::orderBy('likes','desc')->limit(3)->get();
		$jobsResult = $this->indexRepository->getprefJobsPaginated( $request, config('jobs.default_per_page'));
		$pref_jobs_landing = $jobsResult['jobs_pref'];
		if ( $request->old('country_id') ) {
			$states = \DB::table('states')
				->where('country_id', $request->old('country_id'))
				->select(['id', 'name'])
				->get();
		} else {
			$states = \DB::table('states')
				->where('country_id', 222)
				->select(['id', 'name'])
				->get();
		}
		$view = [
			'industries' 		=> $industries,
			'skills' 			=> $skills,
			'job_categories' 	=> $job_categories,
			'countries' 		=> $countries,
			'states'    		=> $states,
			'jobs_landing'    		=> $jobs_landing,
			'pref_jobs_landing'       =>$pref_jobs_landing
		];
		return view('frontend.Index', $view);
	}
	/**
	 * @return \Illuminate\View\View
	 */
	public function employers()
	{
		$countries = DB::table('countries')->select(['id', 'name'])->get();
		if ( auth()->user() && auth()->user()->country_id ) {
			$states = DB::table('states')->where('country_id', auth()->user()->country_id)->select(['id', 'name'])->get();
		} else {
			$states = DB::table('states')->where('country_id', 222)->select(['id', 'name'])->get();
		}
		$data = [
			'countries' => $countries,
			'states'    => $states
		];
		return view('frontend.employers', $data);
	}
	public function employersAction(EmployerSignupRequest $request)
	{
		$this->users->createEmployerUser($request->all());
		alert()->message('Please confirm you account.', 'Thank you!');
		return redirect(route('employers'));
	}
	public function companiesAction()
	{
		dd("company listing action");
	}
	public function test(Request $request){
		return view('frontend.test');
	}
}