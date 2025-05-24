<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ValidateGatewaySecret
{
    public function handle(Request $request, Closure $next)
    {
        // Get the gateway secret from the .env file
        $gatewaySecret = env('GATEWAY_SECRET');
        
        // Get the secret from the Authorization header (Bearer token)
        $providedSecret = $request->bearerToken();

        // If the provided secret doesn't match, return unauthorized error
        if ($providedSecret !== $gatewaySecret) {
            Log::error('Unauthorized access attempt. Provided secret: ' . $providedSecret);
            return response()->json(['error' => 'Unauthorized - Secret mismatch'], 401);
        }

        // Proceed if the secret matches
        return $next($request);
    }
}
