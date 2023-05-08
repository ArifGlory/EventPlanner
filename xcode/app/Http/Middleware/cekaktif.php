<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class cekaktif
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            if (Auth::user()->active != '1') :
                Auth::guard('web')->logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                $msgerror = 'akun anda belum aktif untuk mengakses fungsi ini ' . $request->fullUrl() ;
                return res500(\request()->ajax(), $msgerror);
            else:
                return $next($request);
            endif;
        }

    }
}
