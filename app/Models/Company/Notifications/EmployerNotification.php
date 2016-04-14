<?php

namespace App\Models\Company\Notifications;

use App\Models\Access\User\User;
use App\Models\Company\Notifications\Traits\Attribute\EmployerNotificationAttribute;
use Illuminate\Database\Eloquent\Model;

class EmployerNotification extends Model
{
    use EmployerNotificationAttribute;
    protected $table = 'employer_notifications';
    protected $guarded = ['id'];

    private $actionFullNames = [
        'company_information_updated'   => 'Company Information Updated',
        'job_created'                   => 'Job Created',
        'job_updated'                   => 'Job Updated',
        'job_deleted'                   => 'Job Deleted',
        'project_created'               => 'Project Created',
        'project_updated'               => 'Project Updated',
        'project_deleted'               => 'Project Deleted',
        'task_created'                  => 'Task Created',
        'task_updated'                  => 'Task Updated',
        'task_deleted'                  => 'Task Deleted',
        'news_feed_created'              => 'News Feed Created',
        'news_feed_updated'              => 'News Feed Updated',


    ];



}
