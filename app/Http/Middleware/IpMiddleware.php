<?php

namespace App\Http\Middleware;

use Closure;

class IpMiddleware
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
        $whitelist = array("103.134.94.18" ,"127.0.0.1", "146.88.66.250","180.232.84.234","203.160.173.203","::1","122.49.219.114","43.226.4.194","116.212.138.222","180.210.202.7","110.74.203.179","116.212.138.222","203.189.139.110","202.58.99.14","103.5.45.118", "103.5.45.100", "112.210.230.5", "203.82.38.210", "103.104.16.26", "103.104.16.27", "103.104.16.28", "103.104.16.29", "172.69.134.217");
       // dd($request->ip());
        if(in_array($request->ip(), $whitelist)){
            return $next($request);
        }
        return redirect()->away('http://www.google.com');
    }
}
