<?php namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\EmployerSignupRequest;
use App\Models\Access\User\User;
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

	/**
	 * FrontendController constructor.
	 * @param EloquentUserRepository $users
     */
	public function __construct(EloquentUserRepository $users)
	{

		$this->users = $users;
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
			'states'    		=> $states
		];

		return view('frontend.index', $view);
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
}
