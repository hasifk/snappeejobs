<?php

get('dashboard', 'DashboardController@index')->name('backend.dashboard');
get('profile', 'DashboardController@profile')->name('backend.profile');
post('profile', 'DashboardController@editProfile')->name('backend.profile');
post('notification/unread_messages', 'DashboardController@unread_messages')->name('backend.notification.unread_messages');
post('notification/job_applications', 'DashboardController@job_applications')->name('backend.notification.job_applications');
get('employersearch', 'DashboardController@employersearch')->name('backend.employersearch');
get('get-states/{id}', function($id){
    $states = DB::table('states')->where('country_id', $id)->select(['id', 'name'])->get();
    return response()->json($states);
});

get('employeranalytics/notifications_history', 'DashboardController@notificationsHistory')->name('backend.notifications.history');
get('employeranalytics/interestedjobs', 'EmployerAnalyticsController@interestedjobsanalytics')->name('backend.employerintjobs');
get('employeranalytics/notinterestedjobs', 'EmployerAnalyticsController@notinterestedjobsanalytics')->name('backend.employernotintjobs');
get('staffmemebers/{id}', 'DashboardController@showstaffmembers')->name('staffmembers.show');
get('employeranalytics/companyvisitors', 'EmployerAnalyticsController@companyVisitors')->name('backend.companyvisitors');
get('employeranalytics/jobvisitors', 'EmployerAnalyticsController@jobVisitors')->name('backend.jobvisitors');
get('employeranalytics/uniquejobvisitors', 'EmployerAnalyticsController@uniqueJobVisitors')->name('backend.uniquejobvisitors');
get('employeranalytics/uniquecompanyvisitors', 'EmployerAnalyticsController@uniqueCompanyVisitors')->name('backend.uniquecompanyvisitors');


