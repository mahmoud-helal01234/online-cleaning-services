<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\SiteVisit;
use Illuminate\Http\Request;
use App\Jobs\ProcessSiteVisitJob;
use Illuminate\Support\Facades\Log;

class LogSiteVisit
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
        $ip = $request->ip();
        // $ip = "2001:4860:7:60c::ff";

        $userAgent = $request->header('User-Agent');
        Log::info("LogSiteVisit : Middleware");
        ProcessSiteVisitJob::dispatch($ip, $userAgent);
        Log::info("LogSiteVisit : Middleware after job");

        return $next($request);
    }
}
