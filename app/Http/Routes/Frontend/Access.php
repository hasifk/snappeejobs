<?php

/**
 * Frontend Access Controllers
 */
$router->group(['namespace' => 'Auth'], function () use ($router)
{
	/**
	 * These routes require the user to be logged in
	 */
	$router->group(['middleware' => 'auth'], function ()
	{
		get('auth/logout', 'AuthController@getLogout');
		get('auth/password/change', 'PasswordController@getChangePassword');
		post('auth/password/change', 'PasswordController@postChangePassword')->name('password.change');
		get('auth/connect/facebook', 'AuthController@facebookRedirectToProvider')->name('auth.facebook');
		get('auth/connect/facebook/callback', 'AuthController@facebookHandleProviderCallback');
		get('auth/connect/twitter', 'AuthController@twitterRedirectToProvider')->name('auth.twitter');
		get('auth/connect/twitter/callback', 'AuthController@twitterHandleProviderCallback');
		get('auth/connect/google', 'AuthController@googleRedirectToProvider')->name('auth.google');
		get('auth/connect/google/callback', 'AuthController@googleHandleProviderCallback');
	});

	/**
	 * These reoutes require the user NOT be logged in
	 */
	$router->group(['middleware' => 'guest'], function () use ($router)
	{
		get('auth/login/{provider}', 'AuthController@loginThirdParty')->name('auth.provider');
		get('auth/login/linkedin', 'AuthController@linkedinRedirectToProvider')->name('auth.linkedin');
		get('auth/linkedin/callback', 'AuthController@linkedinHandleProviderCallback');
		get('account/confirm/{token}', 'AuthController@confirmAccount')->name('account.confirm');
		get('account/confirm/resend/{user_id}', 'AuthController@resendConfirmationEmail')->name('account.confirm.resend');
		post('/auth/validate', 'AuthController@validateUser')->name('frontend.access.validate');


		$router->controller('auth', 'AuthController');
		$router->controller('password', 'PasswordController');
	});
});
