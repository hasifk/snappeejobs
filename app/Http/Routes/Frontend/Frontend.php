<?php

/**
 * Frontend Controllers
 */
get('/', 'FrontendController@index')->name('home');
get('/test', 'FrontendController@test')->name('test');
get('/home', 'FrontendController@index')->name('home');
get('employers', 'FrontendController@employers')->name('employers');
post('employers', 'FrontendController@employersAction');
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
	get('profile/favourites', 'ProfileController@favourites')->name('frontend.profile.favourites');
	get('resume/edit', 'ProfileController@editResume')->name('frontend.resume.edit');
	get('preferences/edit', 'ProfileController@editPreferences')->name('frontend.preferences.edit');
	post('preferences/edit', 'ProfileController@saveEmployerPreferences')->name('frontend.preferences.save');
	get('profile/videos', 'ProfileController@videos')->name('frontend.profile.videos');
	post('profile/videos', 'ProfileController@uploadVideos')->name('frontend.profile.upload_videos');
	get('profile/images', 'ProfileController@images')->name('frontend.profile.images');
	post('profile/images', 'ProfileController@uploadImages')->name('frontend.profile.upload_images');
	post('profile/delete_images', 'ProfileController@deleteImage')->name('frontend.profile.delete_images');
	get('profile/socialmedia', 'ProfileController@socialmedia')->name('frontend.profile.socialmedia');
	post('profile/update', 'ProfileController@update')->name('frontend.profile.update');
	post('profile/updateProfileImage', 'ProfileController@updateProfileImage')->name('frontend.profileimage.update');
	post('profile/resume', 'ProfileController@resumeUpload')->name('frontend.profile.resume');
	post('profile/preferences', 'ProfileController@savePreferences')->name('frontend.profile.preferences');
	post('profile/resendConfirmation', 'ProfileController@resendConfirmation')->name('frontend.profile.resend_confirmation');
	post('profile/unreadchats', 'ProfileController@unreadchats')->name('frontend.notification.unreadchats');
	post('profile/rejected_applications', 'ProfileController@rejected_applications')->name('frontend.notification.rejected_applications');
	post('profile/rejected_applications_mark_read', 'ProfileController@rejected_applications_mark_read')->name('frontend.notification.rejected_applications_mark_read');
	get('messages', 'ProfileController@messages')->name('frontend.messages');
	get('message/{id}', 'ProfileController@viewThread')->name('frontend.message');
	post('message/reply/{id}', 'ProfileController@replyThread')->name('frontend.message.reply');
	delete('message/delete/{id}', 'ProfileController@destroyThread')->name('frontend.message.destroy');

});
