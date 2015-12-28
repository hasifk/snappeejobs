<?php

$router->group([
    'prefix' => 'employer',
    'namespace' => 'Employer',
    'middleware' => [
        'access.routeNeedsPermission:employer-users-view',
        'access.routeNeedsSubscription'
    ]
], function() use ($router)
{
    /**
     * Employer user Management
     */
    $router->group(['namespace' => 'Company'], function() use ($router) {
        get('show-profile', 'CompanyController@showProfile')->name('admin.employer.company.showprofile');
        get('edit-profile', 'CompanyController@editProfile')->name('admin.employer.company.editprofile');
        post('update-profile', 'CompanyController@updateProfile')->name('admin.employer.company.updateprofile');
    });
});