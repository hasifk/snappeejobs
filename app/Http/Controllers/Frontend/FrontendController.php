<?php namespace App\Http\Controllers\Frontend;
use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\EmployerSignupRequest;
use App\Models\Company\Company;
use App\Models\Job\Job;

use App\Repositories\Backend\Logs\LogsActivitysRepository;
use App\Repositories\Frontend\Index\EloquentIndexRepository;
use App\Repositories\Frontend\User\EloquentUserRepository;
use DB;
use Illuminate\Http\Request;
use Activity;
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
	private $userLogs;
	/**
	 * FrontendController constructor.
	 * @param EloquentUserRepository $users
	 */
	public function __construct(EloquentUserRepository $users,EloquentIndexRepository $indexRepository,
  LogsActivitysRepository $userLogs)
	{
		$this->users = $users;
		$this->indexRepository = $indexRepository;
		$this->userLogs=$userLogs;
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
		$jobs_landing = Job::orderBy('likes', 'desc')->limit(6)->get();
		$jobsResult = $this->indexRepository->getprefJobsPaginated($request, config('jobs.default_per_page'));

		$pref_jobs_landing = $jobsResult['jobs_pref'];


		if(count($pref_jobs_landing)>0):
			if(count($pref_jobs_landing)<4):
				$joblimit=6-count($pref_jobs_landing);
				$pref_jobs_landing1 = Job::orderBy('likes', 'desc')->limit($joblimit)->where('likes','>','0')->get();
				$pref_jobs_landing=$pref_jobs_landing->merge($pref_jobs_landing1);
			endif;
		endif;


		$companies_landing = Company::orderBy('followers', 'desc')->limit(6)->get();
		if ( auth()->user() && (!empty(auth()->user()->job_seeker_details)) ) {
			$companies_landing1 = Company::join('industry_company', 'industry_company.company_id', '=', 'companies.id')
				->join('job_seeker_industry_preferences', 'job_seeker_industry_preferences.industry_id', '=', 'industry_company.industry_id')
				 ->join('job_seeker_details', 'job_seeker_details.id', '=', 'job_seeker_industry_preferences.user_id')

				->where('job_seeker_details.id', '=', auth()->user()->job_seeker_details->id)
				->select([
					'companies.*',

				])
				->get();
		}
		if(!empty($companies_landing1)):
		if(count($companies_landing1)>0):
			if(count($companies_landing1)<4):
				$complimit=6-count($companies_landing1);
				$companies_landing = Company::orderBy('followers', 'desc')->limit($complimit)->get();
				$companies_landing=$companies_landing->merge($companies_landing1);
				else:
			    $companies_landing=$companies_landing1;
			endif;
			endif;
			endif;

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
			'pref_jobs_landing'       =>$pref_jobs_landing,
			'companies_landing'    =>$companies_landing,


		];

		return view('frontend.index' . ( env('APP_DESIGN') == 'new' ? 'new' : "" ) , $view);
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
		return view('frontend.employers' . ( env('APP_DESIGN') == 'new' ? 'new' : "" ), $data);
	}
	public function employersAction(EmployerSignupRequest $request)
	{

        $array['type'] = 'Employer';
        $array['heading']='With name:'.$request->name;
		if($this->users->createEmployerUser($request->all()))
        {
            $array['event'] = 'created';

            $name = $this->userLogs->getActivityDescriptionForEvent($array);
            Activity::log($name);
        }
		if ( $request->ajax() ) {
			return response()->json([
				'status' => true,
				'message' => 'Please confirm you account.'
			]);
		} else {
			alert()->message('Please confirm you account.', 'Thank you!');
			return redirect(route('employers'));
		}
	}
	public function companiesAction()
	{
		dd("company listing action");
	}
	public function test(Request $request){
		return view('frontend.test');
	}
}
