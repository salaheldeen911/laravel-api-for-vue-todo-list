<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class TodoMiddleware
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
        if ($request->route('todo')) {
            if ($request->route('todo')->user_id !== auth()->user()->id) {
                abort(403, 'You are not allowed to take any actions on this todo');
            }
        }

        return $next($request);
    }
}
