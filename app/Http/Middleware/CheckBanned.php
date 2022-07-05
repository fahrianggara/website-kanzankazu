<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CheckBanned
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
        if (Auth::check() && Auth::user()->banned_at && now()->lessThan(Auth::user()->banned_at)) {

            $banned_days = Auth::user()->banned_at->diffForHumans();

            Auth::logout();

            $message = 'Akun kamu telah di banned selama ' . $banned_days . ', silahkan kontak admin untuk informasi lebih lanjut.';

            return redirect()->route('login')->with('infoban', $message);
        }

        return $next($request);
    }
}
