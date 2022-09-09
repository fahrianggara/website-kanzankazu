<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsAnonymous
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
        // user is anonymous
        if (Auth::user()->provider == 'anonymous') {
            return redirect()->back()->with('info', 'Oops.. kamu tidak bisa masuk ke-halaman Dashoard, dikarenakan kamu login menggunakan Anonymous!');
        }
        return $next($request);
    }
}
