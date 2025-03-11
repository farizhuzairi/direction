<?php

namespace Director\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class Direct
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $request->accessible()->visitorBuild(
            Auth::user(),
            function($visit) {
                $visit->setUserModel();
            },
            function($access) use ($request) {
                $access->bootTrace($request);
            }
        );

        return $next($request);
    }
}