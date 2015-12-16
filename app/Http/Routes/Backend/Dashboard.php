<?php

get('dashboard', 'DashboardController@index')->name('backend.dashboard');
get('profile', 'DashboardController@profile')->name('backend.profile');
post('profile', 'DashboardController@editProfile')->name('backend.profile');
get('get-states/{id}', function($id){
    $states = DB::table('states')->where('country_id', $id)->select(['id', 'name'])->get();
    return response()->json($states);
});