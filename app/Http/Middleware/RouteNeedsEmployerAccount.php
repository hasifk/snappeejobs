<?php

namespace App\Http\Middleware;

use Closure;

class RouteNeedsEmployerAccount
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
        if (! access()->hasRoles(['Employer', 'Employer Staff']) )
            return redirect('/')->withFlashDanger("You do not have access to do that.");
        return $next($request);
    }
}
