<?php

$router->group([
    'prefix' => 'mail',
    'middleware' => [
        'access.routeNeedsPermission:message-employers'
    ]
], function() use ($router)
{
    /**
     * Employer user Management
     */
    $router->group(['namespace' => 'AdminMail'], function() use ($router) {
        get('', 'AdminMailController@index')->name('admin.mail.index');
        get('/getusers/{company_id}', 'AdminMailController@getCompanyUsers');
    });
});
