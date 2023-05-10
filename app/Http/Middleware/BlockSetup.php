<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class BlockSetup
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
        // Check setup is completed or not
        if (setupCompleted()) {
            return redirect()->route("home");
        }

        return $next($request);
    }
}
