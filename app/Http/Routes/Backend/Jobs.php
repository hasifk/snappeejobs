<?php

$router->group([
    'prefix' => 'employer',
    'namespace' => 'Employer',
    'middleware' => [
                        'access.routeNeedsPermission:employer-jobs-view',
                        'access.routeNeedsSubscription',
                        'access.routeNeedsCompany'
                    ]
], function() use ($router)
{
    /**
     * Employer user Management
     */
    $router->group(['namespace' => 'Jobs'], function() use ($router) {

        resource('jobs', 'JobsController', ['except' => ['show']]);

        get('jobs/disabled', 'JobsController@disabled')->name('admin.employer.jobs.disabled');
        get('jobs/hidden', 'JobsController@hidden')->name('admin.employer.jobs.hidden');
        get('jobs/deleted', 'JobsController@deleted')->name('admin.employer.jobs.deleted');

        get('jobs/manage/{id}', 'JobsController@manage')->name('admin.employer.jobs.manage');
        get('jobs/manage-application-status', 'JobsController@manageApplicationStatus')->name('admin.employer.jobs.manage.applicationstatus');
        get('jobs/manage-application-status/edit/{id}', 'JobsController@editApplicationStatus')->name('admin.employer.jobs.manage.applicationstatus.edit');
        post('jobs/manage-application-status/edit/{id}', 'JobsController@updateApplicationStatus')->name('admin.employer.jobs.manage.applicationstatus.update');

        get('jobs/applications', 'JobsController@applications')->name('admin.employer.jobs.applications');
        get('jobs/applicationinbox', 'JobsController@applicationinbox')->name('admin.employer.jobs.applicationinbox');
        get('jobs/application/{id}', 'JobsController@application')->name('admin.employer.jobs.application');
        post('jobs/application/accept/{id}', 'JobsController@acceptJobApplication')->name('admin.employer.jobs.application.accept');
        post('jobs/application/decline/{id}', 'JobsController@declineJobApplication')->name('admin.employer.jobs.application.decline');
        post('jobs/application/changestatus/{id}', 'JobsController@applicationChangeStatus')->name('admin.employer.jobs.application.changestatus');

        $router->group(['prefix' => 'jobs/{id}', 'where' => ['id' => '[0-9]+']], function () {
            get('delete', 'JobsController@delete')->name('admin.employer.jobs.delete-permanently');
            get('restore', 'JobsController@restore')->name('admin.employer.jobs.restore');
            get('mark/{status}', 'JobsController@mark')->name('admin.employer.jobs.mark')->where(['status' => '[0,1,2]']);
            get('publish', 'JobsController@publish')->name('admin.employer.jobs.publish');
            get('hide', 'JobsController@hide')->name('admin.employer.jobs.hide');
        });

    });
});
