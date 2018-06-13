<?php
/**
 * Created by PhpStorm.
 * User: Lukas Figura
 * Date: 15/02/2017
 * Time: 19:40
 */

namespace App\Http\Middleware;

use Auth;
use Closure;

class SuperAdminOOUMiddleware
{
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param  \Closure                 $next
	 *
	 * @return mixed
	 */
	public function handle( $request, Closure $next )
	{
		if (!Auth::check() || ( !Auth::user()->isSuperAdmin() && !Auth::user()->badges()->where('system', true)->where('name', 'OOU_signed')->exists() )) {
			return redirect()->action('Admin\AdminController@index');
		}
		
		return $next($request);
	}
}
