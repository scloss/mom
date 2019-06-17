<?php namespace App\Http\Middleware;

use Closure;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;

class VerifyCsrfToken extends BaseVerifier {

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		//return parent::handle($request, $next);
		$skip = array(
					'entry',
					'goHome',
					'uploads',
					'editProcess',
					'modalMailSend',
					'contactProcess'
					);
 
		foreach ($skip as $key => $route) {
			//skip csrf check on route
			if($request->is($route)){
				return parent::addCookieToResponse($request, $next($request));
			}
		}
 
		return parent::handle($request, $next);
	}

}
