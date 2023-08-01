<?php

namespace App\Http\Middleware;

use JWTAuth;
use Exception;
use Closure;
use Illuminate\Http\Request;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle($request, Closure $next, ...$roles)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();

            // Jika token valid, periksa apakah pengguna memiliki peran yang diizinkan
            foreach ($roles as $role) {
                if ($user->roles->pluck('nama_role')->contains($role)) {
                    return $next($request);
                }
            }

            return response()->json(['error' => 'Unauthorized action.'], 403);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Invalid token.'], 401);
        }
    }
}
