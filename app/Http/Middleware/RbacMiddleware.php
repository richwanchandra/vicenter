<?php

namespace App\Http\Middleware;

use App\Models\Module;
use App\Services\RbacService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RbacMiddleware
{
    public function handle(Request $request, Closure $next, ?string $moduleSlug = null): Response
    {
        $user = $request->user();

        if (!$user) {
            return redirect()->route('login');
        }

        $slug = $moduleSlug;

        if (!$slug) {
            $routeModule = $request->route('module');
            if ($routeModule instanceof Module) {
                $slug = $routeModule->slug;
            } elseif (is_string($routeModule)) {
                $slug = $routeModule;
            }
        }

        if (!$slug) {
            return abort(400, 'Module slug not provided');
        }

        if (!RbacService::check($user, $slug)) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Forbidden'], 403);
            }
            abort(403);
        }

        return $next($request);
    }
}
