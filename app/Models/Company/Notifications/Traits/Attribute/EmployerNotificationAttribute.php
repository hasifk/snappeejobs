<?php

namespace App\Models\Company\Notifications\Traits\Attribute;


use DB;

trait EmployerNotificationAttribute
{

    public function getNewsAttribute(){
        $details = unserialize($this->attributes['details']);


        if ($this->attributes['notification_type'] == 'news_feed_created')
        {
            return $details['newsfeed']->news;
        }

    }
}
