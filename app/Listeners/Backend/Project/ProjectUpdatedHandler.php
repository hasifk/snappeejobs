<?php

namespace App\Listeners\Backend\Project;

use App\Events\Backend\Project\ProjectUpdated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ProjectUpdatedHandler
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  ProjectUpdated  $event
     * @return void
     */
    public function handle(ProjectUpdated $event)
    {
        //
    }
}
