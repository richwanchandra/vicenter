<?php

namespace App\Http\Middleware;

use App\Services\RbacService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Middleware: permission
 *
 * Usage in routes:
 *   ->middleware('permission:inventory')
 *   ->middleware('permission:payments')
 *
 * Parameters: moduleSlug
 */
class CheckPermission
{
    public function handle(Request $request, Closure $next, string $moduleSlug): Response
    {
        $user = $request->user();

        if (!$user) {
            return redirect()->route('login');
        }

        if (RbacService::check($user, $moduleSlug)) {
            return $next($request);
        }

        if ($request->expectsJson()) {
            return response()->json(['message' => 'Forbidden: insufficient permissions.'], 403);
        }

        abort(403, "You do not have permission to access the module [{$moduleSlug}].");
    }
}
