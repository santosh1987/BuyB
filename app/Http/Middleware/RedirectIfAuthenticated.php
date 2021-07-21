<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  ...$guards
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                // $susers = \App\Models\User::where('id',Auth::user()->id)->whereRoleIs(['superadministrator'])->get();
                // $vusers = \App\Models\User::where('id',Auth::user()->id)->whereRoleIs(['administrator','vendor'])->get();
                // $request->session()->regenerate();
               
                // // die(!$susers->isEmpty());
                // //seperating route based on role which is logged in
                // if(!$susers->isEmpty() && $vusers->isEmpty()) {
                //     return redirect()->intended(RouteServiceProvider::SHOME);
                // }
                // elseif ($susers->isEmpty() && !$vusers->isEmpty()) {
                //     return redirect()->intended(RouteServiceProvider::VHOME);
                // }
                return redirect()->intended(RouteServiceProvider::HOME);
            }
        }

        return $next($request);
    }
}
