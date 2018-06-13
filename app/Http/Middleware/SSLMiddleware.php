<?php
/**
 * Created by PhpStorm.
 * User: Lukas Figura
 * Date: 15/02/2017
 * Time: 19:40
 */

namespace App\Http\Middleware;

use Closure;

class SSLMiddleware
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
//        if (!$request->secure() && env('APP_ENV') === 'prod') {
        $request->setTrustedProxies([$request->getClientIp()]);
//
//            return redirect()->secure($request->getRequestUri());
//        }

        return $next($request);
    }
}
