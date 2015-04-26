<?php namespace Kit\Http\Middlewares;

use Sentry;
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
		if (!Sentry::check() or !Sentry::getUser()->hasPermission('admin'))
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