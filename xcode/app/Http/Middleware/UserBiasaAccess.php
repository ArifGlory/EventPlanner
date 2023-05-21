<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserBiasaAccess
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
            if (cekRoleAkses('user')){
                return $next($request);
            }else{
                $msgerror = 'anda tidak bisa mengakses fungsi ini, fungsi ini hanya untuk pengguna SIVP ' . $request->fullUrl();
                return res500(\request()->ajax(), $msgerror);
            }
        }else{
            $msgerror = 'Anda harus login terlebih dahulu untuk dapat mengakses fitur ini';
            return res500(\request()->ajax(), $msgerror);
        }

    }
}
