<?php namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\EmployerSignupRequest;
use DB;

/**
 * Class FrontendController
 * @package App\Http\Controllers
 */
class FrontendController extends Controller {

	/**
	 * @return \Illuminate\View\View
	 */
	public function index()
	{
		javascript()->put([
			'test' => 'it works!'
		]);

		$skills = \DB::table('skills')->select(['id', 'name'])->get();
		$job_categories = \DB::table('job_categories')->select(['id', 'name'])->get();

		$view = [
			'skills' 			=> $skills,
			'job_categories' 	=> $job_categories
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

	public function companies()
	{

		$companies  = DB::table('companies')
			->join('countries','companies.country_id','=','countries.id')
			->join('states','companies.state_id','=','states.id')
			->join('photo_company','companies.id','=','photo_company.company_id')
			->select(
				'companies.*',
				'countries.name As country',
				'states.name As state',
				'photo_company.*'
			)
			->get();

		return view('frontend.companies.index',['companies'=>$companies]);

	}

	public function company($slug)
	{

		$company  = DB::table('companies')
			->join('countries','companies.country_id','=','countries.id')
			->join('states','companies.state_id','=','states.id')
			->join('photo_company','companies.id','=','photo_company.company_id')
			->where('companies.url_slug',$slug)
			->select(
				'companies.*',
				'countries.name As country',
				'states.name As state',
				'photo_company.*'
			)
			->first();

		return view('frontend.companies.company',['company'=>$company]);

	}

	public function companiesAction()
	{
		dd("company listing action");
	}
}