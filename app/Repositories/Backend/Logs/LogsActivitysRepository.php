<?php

namespace App\Repositories\Backend\Logs;


use Illuminate\Http\Request;
use Auth;
use Storage;
use Spatie\Activitylog\LogsActivityInterface;
use Spatie\Activitylog\LogsActivity;

class LogsActivitysRepository implements LogsActivityInterface {

use LogsActivity;

/**
 * Get the message that needs to be logged for the given event name.
 *
 * @param string $eventName
 * @return string
 */

public function getActivityDescriptionForEvent($eventName)
{
    
    if ($eventName['event'] == 'created')
    {
        return  $eventName['type'] . ' Created-New '.$eventName['type'].' is Created with '.$eventName['heading'].'-'.Auth::user()->name;
    }
    if ($eventName['event'] == 'updated')
    {
        return $eventName['type']. ' Updated-The '.$eventName['type'].' '.$eventName['heading'].' is Updated-'.Auth::user()->name;
    }
    if ($eventName['event'] == 'deleted')
    {
        return $eventName['type'] . ' Deleted-The '.$eventName['type'].' '.$eventName['heading'].' is Deleted-'.Auth::user()->name;
    }
    if ($eventName['event'] == 'published')
    {
        return $eventName['type'] .' published-The '.$eventName['type'].' '.$eventName['heading'].' is Published-'.Auth::user()->name;
    }
    if ($eventName['event'] == 'hide')
    {
        return $eventName['type'] .' Hide-The '.$eventName['type'].' '.$eventName['heading'].' is changed the status to not Published-'.Auth::user()->name;
    }

    if ($eventName['event'] == 'purchased')
    {
        return $eventName['type'] .' purchased-The '.$eventName['type'].' '.$eventName['heading'].'-'.Auth::user()->name;
    }
    return '';
}

}
