<?php

/**
 * Frontend Job Controllers
 */

$router->group(['namespace'=>'Company'], function() use ($router)
{

    get('companies', 'CompaniesController@index')->name('companies.search');;
    get('companies/{slug}', 'CompaniesController@company')->name('companies.view')->where(['slug' => '[a-z-A-Z]+']);
    get('companies/{slug}/people/{id}', 'CompaniesController@people');

});