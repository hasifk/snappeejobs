<?php

$router->group([
    'prefix' => 'employer',
    'namespace' => 'Employer',
    'middleware' => ['access.routeNeedsPermission:employer-settings', 'access.routeNeedsRole:Employer']
], function() use ($router)
{
    /**
     * Employer user Management
     */
    $router->group(['namespace' => 'Settings'], function() use ($router) {

        get('settings/dashboard', 'SettingsController@index')->name('admin.employer.settings.dashboard');
        get('settings/plan', 'SettingsController@plan')->name('admin.employer.settings.plan');
        get('settings/choose-plan/{id}', 'SettingsController@choosePlan')->name('admin.employer.settings.choose-plan');
        get('settings/selectplan/{id}', 'SettingsController@selectPlan')->name('admin.employer.settings.selectplan');
        post('settings/selectplan/{id}', 'SettingsController@subscribe')->name('admin.employer.settings.subscribe');
        get('settings/upgradeplan/{id}', 'SettingsController@chooseplanupgrade')->name('admin.employer.settings.chooseplanupgrade');
        post('settings/upgradeplan/{id}', 'SettingsController@upgradeplan')->name('admin.employer.settings.upgradeplan');
        get('settings/upgrade', 'SettingsController@upgrade')->name('admin.employer.settings.upgrade');
        get('settings/creditcard', 'SettingsController@creditcard')->name('admin.employer.settings.creditcard');
        get('settings/cancel', 'SettingsController@cancel')->name('admin.employer.settings.cancel');

    });
});