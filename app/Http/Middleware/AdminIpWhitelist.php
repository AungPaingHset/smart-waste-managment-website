<?php

namespace App\Http\Middleware;

use Closure;

class AdminIpWhitelist
{
    public function handle($request, Closure $next)
    {
        // === CONFIGURATION ===
        // Your laptop's public IP (from ISP)
        // $publicIp = '192.168.1.7';

        // Optional: for local testing on the same machine
        $localIps = ['127.0.0.1', '::1'];

        // === DETERMINE CLIENT IP ===
        $clientIp = $request->ip();

        

        // If behind a proxy/load balancer, check X-Forwarded-For
        if ($request->headers->has('X-Forwarded-For')) {
            // The first IP in the comma-separated list is the client
            $clientIp = trim(explode(',', $request->header('X-Forwarded-For'))[0]);
        }

        $validSecret = env('ADMIN_SECRET');
        

        // === CHECK IF ALLOWED ===
        if (!in_array($clientIp, $localIps)) {
            abort(403, 'Unauthorized.');
        }


        if(!$validSecret) {
            abort(403, 'Unauthorized. required.');
        }

        // === ALLOWED ===
        return $next($request);
    }
}
