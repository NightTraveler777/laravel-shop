<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckUserRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        /*if ( !auth()->check() || !auth()->user()->hasRole($role) ) {
            abort(404);
        }
        return $next($request);*/

        if (auth()->check()) {
            foreach($roles as $role){
                if (auth()->user()->hasRole($role)){
                    return $next($request);
                }
            }
        }

        abort(404);
    }
}
