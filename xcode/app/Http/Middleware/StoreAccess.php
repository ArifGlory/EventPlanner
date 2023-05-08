<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StoreAccess
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
            if (cekRoleAkses('superadmin') == true || cekRoleAkses('store') == true){
                return $next($request);
            }else{
                $msgerror = 'anda tidak bisa mengakses fungsi ini ' . $request->fullUrl();
                return res500(\request()->ajax(), $msgerror);
            }
        }

    }
}
