<?php


    $router->group(['namespace' => 'Cms'], function() use ($router) {
        get('cmss', 'AdminCmsController@showCmss')->name('backend.admin.cmss');
        get('cms', 'AdminCmsController@createCms')->name('backend.admin.cms');
        post('cmssave', 'AdminCmsController@SaveCms')->name('backend.admin.cmssave');
        get('cms/{id}', 'AdminCmsController@showCms')->name('backend.admin.cmsshow');
        get('cms/{id}/edit', 'AdminCmsController@EditCms')->name('backend.admin.cms.edit');
        get('cms/destroy/{id}', 'AdminCmsController@DeleteCms')->name('backend.admin.cms.destroy');
//        post('update-profile', 'CompanyController@updateProfile')->name('admin.employer.company.updateprofile');
    });
