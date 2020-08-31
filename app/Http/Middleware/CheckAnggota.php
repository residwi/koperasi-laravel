<?php

namespace App\Http\Middleware;

use App\Anggota;
use Closure;

class CheckAnggota
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (is_null(auth()->user()->anggota_detail) && !auth()->user()->is_admin) {
            return redirect('daftar-anggota');
        }

        return $next($request);
    }
}
