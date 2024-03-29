<?php namespace App\Http\Middleware;

use Closure;

/**
 * Class RouteNeedsRole
 * @package App\Http\Middleware
 */
class RouteNeedsPermission {

	/**
	 * @param $request
	 * @param callable $next
	 * @param $permission
	 * @return mixed
     */
	public function handle($request, Closure $next, $permission)
	{
		if (! access()->can($permission)){

			\Log::alert("Unauthorised access to route diverted.");

			return redirect(route('backend.dashboard'))->withFlashDanger("You do not have access to do that.");

		}

		return $next($request);
	}
}