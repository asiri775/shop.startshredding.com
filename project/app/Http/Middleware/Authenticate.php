<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            return route('home.user');
        }
    }
    // public function handle($request, Closure $next, ...$guard)
    // {
    //     switch ($guard){
    //         case 'profile':
    //             if (!Auth::guard($guard)->check()){
    //                 return redirect('/shop-signin');   
    //                 // return redirect(route('categories.product', 'dry-clean-laundry'));
    //             }
    //             break;

    //         case 'vendor':
    //             if (!Auth::guard($guard)->check()){
    //                 return redirect('/vendor');
    //             }
    //             break;

    //         case 'plant':
    //             if (!Auth::guard($guard)->check()){
    //                 return redirect('/shop-sign');
    //             }
    //             break;

    //         default:
    //             if (!Auth::guard($guard)->check()){
    //                 return redirect('/admin');
    //             }
    //             break;
    //     }

    //     return $next($request);
    // }
}
