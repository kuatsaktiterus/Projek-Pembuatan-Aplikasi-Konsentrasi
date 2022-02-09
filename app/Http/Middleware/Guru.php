<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Guru
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect('/');
        }

        $activeUser = Auth::user();

        if (!($activeUser->role == 'guru')) {
            return redirect('/app/dashboard')->withWarning('Maaf terjadi kesalahan');
        }
        return $next($request);
    }
}