<?php

$router->group([
    'prefix' => 'subscription',
    'namespace' => 'Subscription',
    'middleware' => ['access.routeNeedsPermission:list-subscriptions', 'access.routeNeedsRole:Administrator']
],function() use ($router){
    get('/', 'SubscriptionController@index')->name('backend.subscription');
    get('/upgradeplan/{userId}', 'SubscriptionController@chooseplanupgrade')->name('backend.user.subscription');
    post('/upgradeplan/{userId}', 'SubscriptionController@upgradeplan')->name('backend.user.subscription.update');
    Route::post('stripe/webhook', '\Laravel\Cashier\WebhookController@handleWebhook');
});




