<?php


    $router->group(['namespace' => 'Cms'], function() use ($router) {
        get('cms', 'AdminCmsController@listsCms')->name('backend.admin.cms_lists');
        get('cms_create', 'AdminCmsController@createCms')->name('backend.admin.cms_create');
        post('cmssave', 'AdminCmsController@SaveCms')->name('backend.admin.cmssave');
        get('cms/{id}', 'AdminCmsController@showCms')->name('backend.admin.cmsshow');
        get('cms/{id}/edit', 'AdminCmsController@EditCms')->name('backend.admin.cms.edit');
        get('cms/destroy/{id}', 'AdminCmsController@DeleteCms')->name('backend.admin.cms.destroy');
        get('cms/hide/{id}', 'AdminCmsController@HideCms')->name('backend.admin.cms.hide');
        get('cms/publish/{id}', 'AdminCmsController@PublishCms')->name('backend.admin.cms.publish');
        get('cms/articles', 'AdminCmsController@articleCms')->name('backend.admin.articles');
        get('cms/blogs', 'AdminCmsController@blogCms')->name('backend.admin.blogs');
//        post('update-profile', 'CompanyController@updateProfile')->name('admin.employer.company.updateprofile');
    });
