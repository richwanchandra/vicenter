<?php

namespace App\Services;

use App\Models\Module;
use App\Models\User;

class RbacService
{
    /**
     * Per-request in-memory cache: [userId => [moduleSlug => bool]]
     */
    private static array $cache = [];

    /**
     * Check if a user has access to a module.
     *
     * @param  User    $user
     * @param  string  $moduleSlug  e.g. 'inventory'
     */
    public static function check(User $user, string $moduleSlug): bool
    {
        if ($user->isSuperAdmin()) {
            return true;
        }

        $userId = $user->id;

        if (isset(self::$cache[$userId][$moduleSlug])) {
            return self::$cache[$userId][$moduleSlug];
        }

        $hasAccess = $user->hasAccessToModule($moduleSlug);

        self::$cache[$userId][$moduleSlug] = $hasAccess;

        return $hasAccess;
    }

    /**
     * Get all modules accessible to a user.
     *
     * @param  User  $user
     * @return \Illuminate\Support\Collection
     */
    public static function getAccessibleModules(User $user)
    {
        if ($user->isSuperAdmin()) {
            return Module::where('is_active', true)->get();
        }

        return Module::whereHas('roles', function ($query) use ($user) {
            $query->whereHas('users', function ($q) use ($user) {
                $q->where('users.id', $user->id);
            });
        })->where('is_active', true)->get();
    }

    /**
     * Clear the in-memory cache.
     */
    public static function clearCache(?int $userId = null): void
    {
        if ($userId !== null) {
            unset(self::$cache[$userId]);
        } else {
            self::$cache = [];
        }
    }
}
