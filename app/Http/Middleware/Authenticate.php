<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Authenticate extends Middleware
{

//    public function handle($request, Closure $next, ...$guards)
//    {
////        Auth::guard('token')->getTokenFromRequest();
////        dd('asdf');
////        config(['auth.defaults.guard' => $guards[0]]);
////        if( Auth::guard('token')->validate());
////        return parent::handle($request, $next, $guards);
//        return $next($request);
//    }

    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo($request): ?string
    {
        return null;
    }
}
