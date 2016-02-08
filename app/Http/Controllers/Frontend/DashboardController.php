<?php namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;

/**
 * Class DashboardController
 * @package App\Http\Controllers\Frontend
 */
class DashboardController extends Controller {

	/**
	 * @return mixed
	 */
	public function index()
	{

        if ( ! auth()->user()->confirmed ) {
            auth()->logout();
            return redirect(route('home'))->withErrors('Please confirm your account');
        }

		return view('frontend.user.dashboard')
			->withUser(auth()->user());
	}
}
