<?php


    $router->group(['namespace' => 'Newsfeed'], function() use ($router) {
        get('newsfeeds', 'AdminNewsfeedController@showNewsfeeds')->name('backend.admin.newsfeeds');
        get('newsfeed', 'AdminNewsfeedController@createNewsfeed')->name('backend.admin.newsfeed');
        post('newsfeedsave', 'AdminNewsfeedController@SaveNewsfeed')->name('backend.admin.newsfeedsave');
        get('newsfeed/{id}', 'AdminNewsfeedController@showNewsfeed')->name('backend.admin.newsfeedshow');
        get('newsfeed/{id}/edit', 'AdminNewsfeedController@EditNewsfeed')->name('backend.admin.newsfeed.edit');
        get('newsfeed/destroy/{id}', 'AdminNewsfeedController@DeleteNewsfeed')->name('backend.admin.newsfeed.destroy');
//        post('update-profile', 'CompanyController@updateProfile')->name('admin.employer.company.updateprofile');
    });
