<?php

get('dashboard', 'DashboardController@index')->name('backend.dashboard');
get('profile', 'DashboardController@profile')->name('backend.profile');
post('profile', 'DashboardController@editProfile')->name('backend.profile');
post('notification/unread_messages', 'DashboardController@unread_messages')->name('backend.notification.unread_messages');
post('notification/job_applications', 'DashboardController@job_applications')->name('backend.notification.job_applications');
post('notification/task_assigned', 'DashboardController@task_assigned')->name('backend.notification.task_assigned');
get('employersearch', 'DashboardController@employersearch')->name('backend.employersearch');
get('get-states/{id}', function($id){
    $states = DB::table('states')->where('country_id', $id)->select(['id', 'name'])->get();
    return response()->json($states);
});

get('employeranalytics/notifications_history', 'DashboardController@notificationsHistory')->name('backend.notifications.history');
get('employeranalytics/newsfeeds_history', 'DashboardController@newsfeedsHistory')->name('backend.newsfeeds.history');
get('employeranalytics/interestedjobs', 'EmployerAnalyticsController@interestedjobsanalytics')->name('backend.employerintjobs');
get('employeranalytics/notinterestedjobs', 'EmployerAnalyticsController@notinterestedjobsanalytics')->name('backend.employernotintjobs');
get('staffmemebers/{id}', 'DashboardController@showstaffmembers')->name('staffmembers.show');
get('employeranalytics/companyvisitors', 'EmployerAnalyticsController@companyVisitors')->name('backend.companyvisitors');
get('employeranalytics/companyauthvisitors', 'EmployerAnalyticsController@companyAuthVisitors')->name('backend.companyauthvisitors');
get('employeranalytics/jobvisitors', 'EmployerAnalyticsController@jobVisitors')->name('backend.jobvisitors');
get('employeranalytics/jobauthvisitors', 'EmployerAnalyticsController@jobAuthVisitors')->name('backend.jobauthvisitors');
get('employeranalytics/uniquejobvisitors', 'EmployerAnalyticsController@uniqueJobVisitors')->name('backend.uniquejobvisitors');
get('employeranalytics/uniquecompanyvisitors', 'EmployerAnalyticsController@uniqueCompanyVisitors')->name('backend.uniquecompanyvisitors');
get('employeranalytics/companyinterestmap', 'EmployerAnalyticsController@companyInterestMap')->name('backend.companyinterestmap');
get('socialmediafeeds/addtwitterinfo', 'SocialMediaFeedsController@addtwitterinfo')->name('backend.addtwitterinfo');
post('socialmediafeeds/storetwitterinfo', 'SocialMediaFeedsController@storetwitterinfo')->name('backend.storetwitterinfo');
get('socialmediafeeds/twitterfeeds', 'SocialMediaFeedsController@twitterfeeds')->name('backend.twitterfeeds');
get('bloggers/createblogger', 'BloggerController@createBlogger')->name('backend.createbloggers');
post('bloggers/storeblogger', 'BloggerController@storeBlogger')->name('backend.storebloggers');
get('bloggers/availablebloggers', 'BloggerController@availableBloggers')->name('backend.availablebloggers');



