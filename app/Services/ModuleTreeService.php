<?php

namespace App\Services;

use App\Models\Module;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class ModuleTreeService
{
    /**
     * Get the full module tree filtered by user permissions.
     * Uses eager loading to avoid N+1 queries.
     *
     * @param User $user
     * @return Collection
     */
    public function getTreeForUser(User $user): Collection
    {
        // Load all active modules with recursive children in one query
        $allModules = Module::where('is_active', true)
            ->orderBy('order_number')
            ->get();

        $cacheKey = 'user:'.$user->id.':module_ids';
        $accessibleIds = Cache::remember($cacheKey, 300, function () use ($user) {
            return $user->getAccessibleModuleIds();
        });

        // Build the tree from root modules
        $rootModules = $allModules->whereNull('parent_id');

        // Filter and nest recursively
        return $this->buildFilteredTree($rootModules, $allModules, $accessibleIds, $user->isSuperAdmin());
    }

    /**
     * Recursively build filtered tree.
     *
     * @param Collection $modules Current level modules
     * @param Collection $allModules All modules (flat)
     * @param array $accessibleIds Module IDs user can access
     * @param bool $isSuperAdmin
     * @return Collection
     */
    protected function buildFilteredTree(
        Collection $modules,
        Collection $allModules,
        array $accessibleIds,
        bool $isSuperAdmin
    ): Collection {
        return $modules->filter(function ($module) use ($allModules, $accessibleIds, $isSuperAdmin) {
            // Super admin sees everything
            if ($isSuperAdmin) {
                return true;
            }
            // User must have access to this module
            return in_array($module->id, $accessibleIds);
        })->map(function ($module) use ($allModules, $accessibleIds, $isSuperAdmin) {
            // Get children of this module from the flat list
            $children = $allModules->where('parent_id', $module->id)->sortBy('order_number');

            // Recursively filter children
            $filteredChildren = $this->buildFilteredTree($children, $allModules, $accessibleIds, $isSuperAdmin);

            // Attach filtered children as a dynamic relation
            $module->setRelation('children', $filteredChildren->values());

            return $module;
        })->values();
    }

    /**
     * Get breadcrumbs for a module (from root to current).
     *
     * @param Module $module
     * @return array
     */
    public function getBreadcrumbs(Module $module): array
    {
        $breadcrumbs = [];
        $current = $module;

        while ($current) {
            array_unshift($breadcrumbs, [
                'name' => $current->name,
                'slug' => $current->slug,
                'id' => $current->id,
            ]);
            $current = $current->parent;
        }

        return $breadcrumbs;
    }
}
