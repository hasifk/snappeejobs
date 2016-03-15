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

get('employeranalytics/interestedjobs', 'DashboardController@interestedjobsanalytics')->name('backend.employerintjobs');
get('staffmemebers/{id}', 'DashboardController@showstaffmembers')->name('staffmembers.show');


