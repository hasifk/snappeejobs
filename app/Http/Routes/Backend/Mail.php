<?php

$router->group([
    'prefix' => 'employer',
    'namespace' => 'Employer',
    'middleware' => ['access.routeNeedsPermission:mail-view-private-messages', 'access.routeNeedsRole:Employer']
], function() use ($router)
{
    /**
     * Employer user Management
     */
    $router->group(['namespace' => 'Mail'], function() use ($router) {

        get('mail/dashboard', 'MailController@index')->name('admin.employer.mail.dashboard');
        get('mail/create', 'MailController@create')->name('admin.employer.mail.create');
        post('mail/send', 'MailController@send')->name('admin.employer.mail.store');
        get('mail/inbox', 'MailController@inbox')->name('admin.employer.mail.inbox');
        get('mail/sent', 'MailController@sent')->name('admin.employer.mail.sent');

    });
});