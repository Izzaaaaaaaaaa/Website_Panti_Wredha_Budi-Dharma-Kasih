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
        // Cek apakah user sudah login via Sanctum (API token)
        if (auth('sanctum')->check()) {
            $user = auth('sanctum')->user();
            
            // Cek apakah user adalah admin
            if ($user && $user->isAdmin()) {
                return $next($request);
            }
        }
        
        // Jika tidak ada auth, redirect ke login admin
        if ($request->expectsJson()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized. Please login as admin.'
            ], 401);
        }
        
        return redirect()->route('admin.login')->with('error', 'Silakan login terlebih dahulu');
    }

}
