<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class TataUsaha
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
        try {
            $user = JWTAuth::parseToken()->authenticate();

            // Jika token valid, periksa apakah pengguna memiliki peran yang diizinkan (admin atau peserta)
            if ($user->roles->contains('tatausaha', 1)) {
                return $next($request);
            }

            return response()->json(['error' => 'Unauthorized action.'], 403);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Invalid token.'], 401);
        }
    }
}
