<?php

namespace App\Http\Middleware;

use App\Services\SupabaseAuthService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class SupabaseAuthMiddleware
{
    protected SupabaseAuthService $supabase;

    public function __construct(SupabaseAuthService $supabase)
    {
        $this->supabase = $supabase;
    }

    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $accessToken = Session::get('supabase_access_token');
        $refreshToken = Session::get('supabase_refresh_token');

        if (!$accessToken) {
            return $next($request);
        }

        // Verify token is still valid
        $payload = $this->supabase->verifyToken($accessToken);

        if (!$payload) {
            // Try to refresh
            if ($refreshToken) {
                $result = $this->supabase->refreshToken($refreshToken);
                
                if ($result['success']) {
                    Session::put('supabase_access_token', $result['data']['access_token']);
                    Session::put('supabase_refresh_token', $result['data']['refresh_token']);
                } else {
                    // Clear invalid session
                    Session::forget(['supabase_access_token', 'supabase_refresh_token']);
                    Auth::logout();
                }
            }
        }

        return $next($request);
    }
}
