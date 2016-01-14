<?php

/**
 * Frontend Controllers
 */
get('/', 'FrontendController@index')->name('home');
get('/home', 'FrontendController@index')->name('home');
get('employers', 'FrontendController@employers');
post('employers', 'FrontendController@employersAction');
get('companies', 'FrontendController@companies');
get('companies/{slug}', 'FrontendController@company');
get('companies/{slug}/people/{id}', 'FrontendController@people');
get('get-states/{id}', function($id){
	$states = DB::table('states')->where('country_id', $id)->select(['id', 'name'])->get();
	return response()->json($states);
});

/**
 * These frontend controllers require the user to be logged in
 */
$router->group(['middleware' => 'auth'], function ()
{
	get('dashboard', 'DashboardController@index')->name('frontend.dashboard');
	get('profile/edit', 'ProfileController@edit')->name('frontend.profile.edit');
	post('profile/update', 'ProfileController@update')->name('frontend.profile.update');
	post('profile/resume', 'ProfileController@resumeUpload')->name('frontend.profile.resume');
	post('profile/preferences', 'ProfileController@savePreferences')->name('frontend.profile.preferences');
});