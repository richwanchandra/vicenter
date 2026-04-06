<?php

namespace App\Http\Controllers;

use App\Models\Module;
use App\Services\ModuleTreeService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class DashboardController extends Controller
{
    protected ModuleTreeService $moduleTreeService;

    public function __construct(ModuleTreeService $moduleTreeService)
    {
        $this->moduleTreeService = $moduleTreeService;
    }

    /**
     * Display user dashboard.
     */
    public function index(): View|RedirectResponse
    {
        $user = auth()->user();

        // Redirect admin/super_admin to admin dashboard
        if ($user->isSuperAdmin() || $user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }

        $moduleTree = $this->moduleTreeService->getTreeForUser($user);

        return view('user.dashboard', [
            'moduleTree' => $moduleTree,
        ]);
    }

    /**
     * Display module content.
     */
    public function showModule(Module $module): View
    {
        $user = auth()->user();

        if (!$user->hasAccessToModule($module->id)) {
            abort(403);
        }

        // Get the full module tree for navbar
        $moduleTree = $this->moduleTreeService->getTreeForUser($user);

        // Get breadcrumbs
        $breadcrumbs = $this->moduleTreeService->getBreadcrumbs($module);

        // Optimized: Load all modules and contents in one/two queries and build the sub-tree
        $this->loadUnifiedContent($module, $user);

        return view('user.module-content', [
            'module' => $module,
            'moduleTree' => $moduleTree,
            'breadcrumbs' => $breadcrumbs,
        ]);
    }

    /**
     * Efficiently load all descendants and their contents with permission checks.
     */
    protected function loadUnifiedContent(Module $module, $user): void
    {
        // 1. Load ALL active modules and their published contents in one query
        // Since the total number of modules is small (86), this is more efficient.
        $allModules = Module::where('is_active', true)
            ->with(['contents' => function($q) {
                $q->where('status', 'publish');
            }])
            ->get();

        // 2. Get accessible IDs for this user
        $accessibleIds = $user->isSuperAdmin() 
            ? $allModules->pluck('id')->toArray() 
            : $user->getAccessibleModuleIds();

        // 3. Build the tree structure starting from the current module
        $this->buildAccessibleTree($module, $allModules, $accessibleIds);
    }

    protected function buildAccessibleTree(Module $current, $allModules, $accessibleIds): void
    {
        // Set contents from the preloaded collection
        $loaded = $allModules->firstWhere('id', $current->id);
        if ($loaded) {
            $current->setRelation('contents', $loaded->contents);
        }

        // Filter and build children
        $children = $allModules->where('parent_id', $current->id)
            ->filter(fn($m) => in_array($m->id, $accessibleIds))
            ->sortBy('order_number');

        foreach ($children as $child) {
            $this->buildAccessibleTree($child, $allModules, $accessibleIds);
        }

        $current->setRelation('children', $children->values());
    }
}
