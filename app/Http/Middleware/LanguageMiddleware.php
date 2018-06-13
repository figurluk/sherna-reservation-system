<?php
/**
 * Created by PhpStorm.
 * User: Lukas Figura
 * Date: 15/02/2017
 * Time: 19:40
 */

namespace App\Http\Middleware;

use Closure;
use Config;

class LanguageMiddleware
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
        if (\Session::get('lang') == null) {
            \Session::put('lang', Config::get('app.locale'));
        } else {
            \App::setLocale(\Session::get('lang'));
        }

        return $next($request);
    }
}
