<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        // Untuk web routes, kita skip middleware karena auth dilakukan di client-side (JavaScript)
        // Middleware ini hanya untuk API routes yang sudah di-handle oleh AdminMiddleware
        
        // Jika request dari browser (bukan API), langsung lanjutkan
        // Auth checking akan dilakukan di JavaScript
        return $next($request);
    }

}
