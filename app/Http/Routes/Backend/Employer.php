<?php

$router->group([
    'prefix' => 'employer',
    'namespace' => 'Employer',
    'middleware' => 'access.routeNeedsPermission:employer-users-view'
], function() use ($router)
{
    /**
     * Employer user Management
     */
    $router->group(['namespace' => 'Staff'], function() use ($router) {
        resource('staffs', 'EmployerController', ['except' => ['show']]);

        get('staffs/deactivated', 'EmployerController@deactivated')->name('admin.employer.staffs.deactivated');
        get('staffs/banned', 'EmployerController@banned')->name('admin.employer.staffs.banned');
        get('staffs/deleted', 'EmployerController@deleted')->name('admin.employer.staffs.deleted');
        get('staffs/confirm/resend/{user_id}', 'EmployerController@resendConfirmationEmail')->name('admin.employer.confirm.resend');

        /**
         * Specific Employer
         */
        $router->group(['prefix' => 'staffs/{id}', 'where' => ['id' => '[0-9]+']], function () {
            get('delete', 'EmployerController@delete')->name('admin.employer.staffs.delete-permanently');
            get('restore', 'EmployerController@restore')->name('admin.employer.staffs.restore');
            get('mark/{status}', 'EmployerController@mark')->name('admin.employer.staffs.mark')->where(['status' => '[0,1,2]']);
            get('password/change', 'EmployerController@changePassword')->name('admin.employer.staffs.change-password');
            post('password/change', 'EmployerController@updatePassword')->name('admin.employer.staffs.change-password');
        });
    });
});