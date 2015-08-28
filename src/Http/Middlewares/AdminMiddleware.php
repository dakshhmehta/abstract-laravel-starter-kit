<?php namespace Kit\Http\Middlewares;

use Sentinel;
use Closure;

class AdminMiddleware {
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		if (!Sentinel::check() or !Sentinel::getUser()->hasAccess('admin'))
		{
			if ($request->ajax())
			{
				return response('Unauthorized.', 401);
			}
			else
			{
				return redirect()->guest('authenticate/signin');
			}
		}

		return $next($request);
	}
}