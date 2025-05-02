<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App;
class ApiToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {

        App::setLocale($request->header('Accept-Language'));

        if($request->header('api-token') != 'aquacare212')
            return response()->json(null,404);

        return $next($request);
    }
}
