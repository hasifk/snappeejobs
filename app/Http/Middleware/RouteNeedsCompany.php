<?php

namespace App\Http\Middleware;

use Closure;

class RouteNeedsCompany
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
        if ( ! auth()->user()->employerHasCompany() ) {
            return redirect(route('backend.dashboard'))->withFlashDanger("Please go to the company profile page
            and enter the company details to continue");
        }
        return $next($request);
    }
}
