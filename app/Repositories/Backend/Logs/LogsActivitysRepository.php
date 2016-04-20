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
       $author=$eventName['type'];
    if(!empty(Auth::user()->name)):
        $author=Auth::user()->name;
        endif;
    if ($eventName['event'] == 'created')
    {
        return  $eventName['type'] . ' Created-New '.$eventName['type'].' is Created with '.$eventName['heading'].'-'.$author;
    }
    if ($eventName['event'] == 'updated')
    {
        return $eventName['type']. ' Updated-The '.$eventName['type'].' '.$eventName['heading'].' is Updated-'.$author;
    }
    if ($eventName['event'] == 'deleted')
    {
        return $eventName['type'] . ' Deleted-The '.$eventName['type'].' '.$eventName['heading'].' is Deleted-'.$author;
    }
    if ($eventName['event'] == 'permanentlydeleted')
    {
        return $eventName['type'] . ' Deleted-The '.$eventName['type'].' '.$eventName['heading'].' is Permanently Deleted-'.$author;
    }
    if ($eventName['event'] == 'published')
    {
        return $eventName['type'] .' published-The '.$eventName['type'].' '.$eventName['heading'].' is Published-'.$author;
    }
    if ($eventName['event'] == 'hide')
    {
        return $eventName['type'] .' Hide-The '.$eventName['type'].' '.$eventName['heading'].' is changed the status to not Published-'.$author;
    }

    if ($eventName['event'] == 'purchased')
    {
        return $eventName['type'] .' purchased-The '.$eventName['type'].' '.$eventName['heading'].'-'.$author;
    }

    if ($eventName['event'] == 'restored')
    {
        return $eventName['type'] .' restored-The '.$eventName['type'].' '.$eventName['heading'].'-'.$author;
    }
    if ($eventName['event'] == 'loggedIn')
    {
        return $eventName['type'] .' logged in-The '.$eventName['type'].' '.$eventName['heading'].'-'.$author;
    }
    if ($eventName['event'] == 'loggedOut')
    {
        return $eventName['type'] .' logged out-The '.$eventName['type'].' '.$eventName['heading'].'-'.$author;
    }
    return '';
}

}
