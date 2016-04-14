<?php

namespace App\Models\Company\Notifications\Traits\Attribute;


use DB;

trait EmployerNotificationAttribute
{

    public function getActiontakerAttribute(){
        $details = unserialize($this->attributes['details']);

        if (
            ($this->attributes['notification_type'] == 'job_created') ||
            ($this->attributes['notification_type'] == 'job_updated') ||
            ($this->attributes['notification_type'] == 'job_deleted') ||
            ($this->attributes['notification_type'] == 'project_created') ||
            ($this->attributes['notification_type'] == 'project_updated') ||
            ($this->attributes['notification_type'] == 'project_deleted') ||
            ($this->attributes['notification_type'] == 'task_created') ||
            ($this->attributes['notification_type'] == 'task_updated') ||
            ($this->attributes['notification_type'] == 'task_deleted')
        )
        {
            return $details['user']['name'];
        }

        if (
        ($this->attributes['notification_type'] == 'news_feed_created')||
        ($this->attributes['notification_type'] == 'news_feed_updated')
        ) {
            return $details['adminuser']['name'];
        }


    }

    public function getActionAttribute(){
        return $this->actionFullNames[$this->attributes['notification_type']];
    }

    public function getTitleAttribute(){
        $details = unserialize($this->attributes['details']);

        if (
            ($this->attributes['notification_type'] == 'job_created') ||
            ($this->attributes['notification_type'] == 'job_updated') ||
            ($this->attributes['notification_type'] == 'job_deleted')
        ) {
            return $details['job']['title'];
        }


        if (
        ($this->attributes['notification_type'] == 'news_feed_created')||
        ($this->attributes['notification_type'] == 'news_feed_updated')
        )
        {
            return $details['newsfeed']['news'];
        }
        if (
            ($this->attributes['notification_type'] == 'project_created') ||
            ($this->attributes['notification_type'] == 'project_updated') ||
            ($this->attributes['notification_type'] == 'project_deleted')
        ) {
            return $details['project']['title'];
        }
        if (
            ($this->attributes['notification_type'] == 'task_created') ||
            ($this->attributes['notification_type'] == 'task_updated') ||
            ($this->attributes['notification_type'] == 'task_deleted')
        ) {
            return $details['task']['title'];
        }

    }


}
