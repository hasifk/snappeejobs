<?php

$router->group([
    'prefix' => 'subscription',
    'namespace' => 'Subscription',
    'middleware' => ['access.routeNeedsPermission:list-subscriptions', 'access.routeNeedsRole:Administrator']
],function() use ($router){
    get('/', 'SubscriptionController@index')->name('backend.subscription');
});

