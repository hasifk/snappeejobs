<?php

$router->group([
    'prefix' => 'employer',
    'namespace' => 'Employer',
    'middleware' => [
        'access.routeNeedsSubscription',
        'access.routeNeedsCompany'
    ]
], function() use ($router)
{
    /**
     * Employer user Management
     */
    $router->group(['namespace' => 'GroupChat'], function() use ($router) {

        get('groupchat', 'EmployerGroupChatController@chat')->name('admin.employer.groupchat');
        post('sendmessage', 'EmployerGroupChatController@sendmessage')->name('admin.employer.groupchat.sendmessage');
        get('testregex', 'EmployerGroupChatController@testregex')->name('admin.employer.testregex');

    });
});
