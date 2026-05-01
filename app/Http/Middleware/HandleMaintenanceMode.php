<?php

namespace App\Http\Middleware;

use App\Models\SiteSetting;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class HandleMaintenanceMode
{
    public function handle(Request $request, Closure $next): Response
    {
        // Admin panel always accessible
        if ($request->is('admin', 'admin/*')) {
            return $next($request);
        }

        $settings = SiteSetting::getAllCached();

        if (! $settings->get('maintenance_mode')) {
            return $next($request);
        }

        // Bypass by whitelisted IP
        $allowedIps = array_filter(array_map('trim', explode(',', (string) $settings->get('maintenance_allowed_ips', ''))));
        if (! empty($allowedIps) && in_array($request->ip(), $allowedIps)) {
            return $next($request);
        }

        // Bypass by secret token (?bypass=TOKEN)
        $bypassToken = $settings->get('maintenance_bypass_token');
        if ($bypassToken && $request->query('bypass') === $bypassToken) {
            return $next($request);
        }

        return response()->view('maintenance', [
            'message' => $settings->get('maintenance_message', 'Le site est temporairement en maintenance.'),
            'settings' => $settings,
        ], 503);
    }
}
