<?php

namespace Director\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Director\Services\Direction;
use Illuminate\Support\Facades\Auth;
use Director\Services\VisitorService;
use Director\Services\ApplicationService;
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
            new VisitorService(Auth::user()),
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