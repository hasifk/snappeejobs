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

    });
});
