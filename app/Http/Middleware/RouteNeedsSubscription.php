<?php

namespace App\Http\Middleware;

use Closure;

class RouteNeedsSubscription
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ( ! auth()->user()->isEmployerSubscribed() ) {
            return redirect(route('backend.dashboard'))->withFlashDanger("Please go to the settings page and subscribe to a plan to continue");
        }
        return $next($request);
    }
}
