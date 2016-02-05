<?php namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\EmployerSignupRequest;
use App\Models\Company\Company;
use App\Models\Company\People\People;
use DB;
use Illuminate\Http\Request;

/**
 * Class FrontendController
 * @package App\Http\Controllers
 */
class FrontendController extends Controller {

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
        $this->users->create(
            $request->except('assignees_roles', 'permission_user'),
            [
                'assignees_roles' => [

                ]
            ],
            $request->only('permission_user')
        );
	}

	public function companiesAction()
	{
		dd("company listing action");
	}
}
