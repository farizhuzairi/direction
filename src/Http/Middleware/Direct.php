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
            
            /**
             * Has Visitor
             */
            Auth::user(),

            /**
             * Create Visitable instance
             */
            function($visit) {
                $visit->setUserModel(null);
            },

            /**
             * Closure for Create Serviceable instance and boot system
             */
            function($access) {
                $access->bootTrace();
            }

        );

        return $next($request);
    }
}