<?php


    $router->group(['namespace' => 'Logs'], function() use ($router) {
        get('log_viewer/logs', 'AdminLogController@showLogs')->name('backend.admin.logs');
        
     
    });
