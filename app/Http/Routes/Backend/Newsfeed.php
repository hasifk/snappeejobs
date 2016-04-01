<?php


    $router->group(['namespace' => 'Newsfeed'], function() use ($router) {
        get('newsfeeds', 'AdminNewsfeedController@showNewsfeeds')->name('backend.admin.newsfeeds');
        get('newsfeed', 'AdminNewsfeedController@createNewsfeed')->name('backend.admin.newsfeed');
        post('newsfeedsave', 'AdminNewsfeedController@SaveNewsfeed')->name('backend.admin.newsfeedsave');
//        post('update-profile', 'CompanyController@updateProfile')->name('admin.employer.company.updateprofile');
    });
