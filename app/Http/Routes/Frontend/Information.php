<?php

$router->group(['namespace' => 'Information'], function () use ($router)
{
    get('aboutus', 'InformationController@aboutus')->name('information.aboutus');
    get('terms', 'InformationController@terms')->name('information.terms');
    get('privacy', 'InformationController@privacy')->name('information.privacy');
    get('career', 'InformationController@career')->name('information.career');
    get('contact', 'InformationController@contact')->name('information.contact');
    get('faq', 'InformationController@faq')->name('information.faq');
});