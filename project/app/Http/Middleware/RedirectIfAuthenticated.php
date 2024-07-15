<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        switch ($guard){
            case 'profile':
                if (Auth::guard($guard)->check()){
                    return redirect('/');
                    // return redirect(route('categories.product', 'dry-clean-laundry'));
                }
                //return redirect('/shop-signin');

                break;

            case 'vendor':
                if (Auth::guard($guard)->check()){
                    return redirect(route('vendor.dashboard'));
                }
                break;

            case 'plant':
                if (Auth::guard($guard)->check()){
                    return redirect(route('plant.dashboard'));

                }
                break;

            default:
                if (Auth::guard($guard)->check()) {
                    return redirect('admin/dashboard');
                }
                break;
        }

        return $next($request);
    }
}
