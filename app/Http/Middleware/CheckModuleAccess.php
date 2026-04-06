<?php

namespace App\Http\Middleware;

use App\Models\Module;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckModuleAccess
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, string $moduleSlug): Response
    {
        $module = Module::where('slug', $moduleSlug)->first();

        if (!$module) {
            return abort(404);
        }

        // Super admin has access to everything
        if (auth()->check() && auth()->user()->isSuperAdmin()) {
            return $next($request);
        }

        // Check if user has access to this module
        if (auth()->check() && auth()->user()->hasModuleAccess($module)) {
            return $next($request);
        }

        return abort(403, 'Unauthorized access to this module');
    }
}
