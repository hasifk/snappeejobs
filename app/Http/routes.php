<?php

/**
 * Switch between the included languages
 */
$router->group(['namespace' => 'Language'], function () use ($router)
{
//	require(__DIR__ . "/Routes/Language/Lang.php");
});

/**
 * Frontend Routes
 * Namespaces indicate folder structure
 */
$router->group(['namespace' => 'Frontend'], function () use ($router)
{
	require(__DIR__ . "/Routes/Frontend/Frontend.php");
	require(__DIR__ . "/Routes/Frontend/Company.php");
	require(__DIR__ . "/Routes/Frontend/Job.php");
	require(__DIR__ . "/Routes/Frontend/Access.php");
	require(__DIR__ . "/Routes/Frontend/JobSeekers.php");
	require(__DIR__ . "/Routes/Frontend/Information.php");
    require(__DIR__ . "/Routes/Frontend/Blogs.php");

});

/**
 * Backend Routes
 * Namespaces indicate folder structure
 */

$router->group(['namespace' => 'Backend'], function () use ($router)
{
	$router->group(['prefix' => 'admin', 'middleware' => 'auth'], function () use ($router)
	{
		/**
		 * These routes need view-backend permission (good if you want to allow more than one group in the backend, then limit the backend features by different roles or permissions)
		 *
		 * Note: Administrator has all permissions so you do not have to specify the administrator role everywhere.
		 */
		$router->group(['middleware' => 'access.routeNeedsPermission:view-backend'], function () use ($router)
		{
			require(__DIR__ . "/Routes/Backend/Dashboard.php");
			require(__DIR__ . "/Routes/Backend/Access.php");
			require(__DIR__ . "/Routes/Backend/Employer.php");
			require(__DIR__ . "/Routes/Backend/AdminCompany.php");
			require(__DIR__ . "/Routes/Backend/AdminMail.php");
			require(__DIR__ . "/Routes/Backend/Company.php");
			require(__DIR__ . "/Routes/Backend/Jobs.php");
			require(__DIR__ . "/Routes/Backend/GroupChat.php");
			require(__DIR__ . "/Routes/Backend/Mail.php");
			require(__DIR__ . "/Routes/Backend/Settings.php");
			require(__DIR__ . "/Routes/Backend/Subscription.php");
			require(__DIR__ . "/Routes/Backend/JobSeekers.php");
                        require(__DIR__ . "/Routes/Backend/Newsfeed.php");
                        require(__DIR__ . "/Routes/Backend/Cms.php");

                        require(__DIR__ . "/Routes/Backend/Logs.php");
			require(__DIR__ . "/Routes/Backend/Projects.php");
            require(__DIR__ . "/Routes/Backend/Blogs.php");
		});
	});
});

Route::post('stripe/webhook', '\Laravel\Cashier\WebhookController@handleWebhook');

