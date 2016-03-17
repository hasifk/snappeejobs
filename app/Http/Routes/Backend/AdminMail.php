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
        get('/sent', 'AdminMailController@sent')->name('admin.mail.sent');
        get('/view/{id}', 'AdminMailController@show')->name('admin.mail.view');
        post('/reply/{thread_id}', 'AdminMailController@reply')->name('admin.mail.reply');
        delete('thread/{thread_id}', 'AdminMailController@destroy')->name('admin.mail.destroy');
        get('/newmessage', 'AdminMailController@create')->name('admin.mail.create');
        get('/getusers/{company_id}', 'AdminMailController@getCompanyUsers');
        post('/send_message', 'AdminMailController@sendMessage')->name('admin.mail.send');
    });
});
