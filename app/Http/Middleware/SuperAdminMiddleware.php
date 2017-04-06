<?php

namespace App\Http\Middleware;

use Closure;

class SuperAdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!\Auth::check() || !\Auth::user()->isSuperAdmin()) {
            return redirect()->action('Admin\AdminController@index');
        }

        return $next($request);
    }
}
