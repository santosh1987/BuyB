<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('login');
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(LoginRequest $request)
    {
        // echo "hi";
        $request->authenticate();
        // print_r($request->authenticate());
        // die($users = \App\Models\User::whereRoleIs(['superadministrator'])->get());
        $susers = \App\Models\User::where('id',Auth::user()->id)->whereRoleIs(['superadministrator'])->get();
        $vusers = \App\Models\User::where('id',Auth::user()->id)->whereRoleIs(['administrator','vendor'])->get();
        $request->session()->regenerate();
        // die($susers->isEmpty());
        // if(!$susers->isEmpty() && $vusers->isEmpty()) {
        //     return redirect()->intended(RouteServiceProvider::SHOME);
        // }
        // elseif ($susers->isEmpty() && !$vusers->isEmpty()) {
        //     return redirect()->intended(RouteServiceProvider::VHOME);
        // }
        return redirect()->intended(RouteServiceProvider::HOME);
    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
