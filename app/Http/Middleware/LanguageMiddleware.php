<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;

class LanguageMiddleware
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
        $lang = $request->query('lang'); // Get 'lang' from the query parameters
        
        if ($lang && in_array($lang, ['en', 'ar'])) {
            App::setLocale($lang); // Set the application locale
            session(['locale' => $lang]); // Store locale in session for persistence
        } 

        return $next($request);
    }
}
