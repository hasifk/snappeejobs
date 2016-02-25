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
        get('newcompanies', 'AdminCompanyController@newcompanies')->name('admin.company.newcompanies');
        get('company/{id}', 'AdminCompanyController@show')->name('admin.company.show');
        get('company/create/{id}', 'AdminCompanyController@create')->name('admin.company.create');
        post('company/store/{id}', 'AdminCompanyController@store')->name('admin.company.store');
        get('company/edit/{id}', 'AdminCompanyController@edit')->name('admin.company.edit');
        post('company/update/{id}', 'AdminCompanyController@update')->name('admin.company.update');
    });
});
