<?php

$router->group([
    'middleware' => [
        'access.routeNeedsPermission:company-management'
    ]
], function() use ($router)
{
    /**
     * Employer user Management
     */
    $router->group(['namespace' => 'Company'], function() use ($router) {
        get('companies', 'AdminCompanyController@index')->name('admin.company.index');
        get('company/{id}', 'AdminCompanyController@show')->name('admin.company.show');
        get('company/edit/{id}', 'AdminCompanyController@edit')->name('admin.company.edit');
        post('company/update/{id}', 'AdminCompanyController@update')->name('admin.company.update');
    });
});
