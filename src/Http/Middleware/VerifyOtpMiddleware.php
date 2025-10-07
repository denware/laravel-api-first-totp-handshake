<?php

namespace YourName\TOTPHandshake\Http\Middleware;

use Closure;
use YourName\TOTPHandshake\Services\TOTPService;

class VerifyOtpMiddleware
{
    public function handle($request, Closure $next)
    {
        $code = $request->header('X-OTP');

        if (!$code || !TOTPService::verify($code)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid or missing OTP code.'
            ], 401);
        }

        return $next($request);
    }
}
