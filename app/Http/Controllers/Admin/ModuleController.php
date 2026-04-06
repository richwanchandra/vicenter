<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Module;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ModuleController extends Controller
{
    /**
     * Display a listing of modules.
     */
    public function index(): View
    {
        $modules = Module::whereNull('parent_id')
            ->with([
                'children' => function ($q) {
                    $q->orderBy('order_number')
                      ->with([
                          'children' => function ($qq) {
                              $qq->orderBy('order_number')
                                 ->with('children'); // prefetch up to 3 levels
                          },
                          'contents:id,module_id,title,status',
                      ]);
                },
                'contents:id,module_id,title,status',
            ])
            ->withCount('contents')
            ->orderBy('order_number')
            ->get();
        $moduleUserCounts = DB::table('modules')
            ->leftJoin('role_module_access', 'modules.id', '=', 'role_module_access.module_id')
            ->leftJoin('user_roles', 'role_module_access.role_id', '=', 'user_roles.role_id')
            ->select('modules.id', DB::raw('COUNT(DISTINCT user_roles.user_id) as user_count'))
            ->groupBy('modules.id')
            ->pluck('user_count', 'modules.id');

        return view('admin.modules.index', [
            'modules' => $modules,
            'moduleUserCounts' => $moduleUserCounts,
        ]);
    }

    /**
     * Show the form for creating a new module.
     */
    public function create(?int $parentId = null): View
    {
        $parents = Module::whereNull('parent_id')
            ->with(['children' => function($query) {
                $query->orderBy('name')->with(['children' => function($subQuery) {
                    $subQuery->orderBy('name');
                }]);
            }])
            ->orderBy('name')
            ->get();

        return view('admin.modules.create', [
            'parents' => $parents,
            'parentId' => $parentId,
        ]);
    }

    /**
     * Store a newly created module in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'parent_id' => ['nullable', 'exists:modules,id'],
            'order_number' => ['nullable', 'integer'],
            'is_active' => ['boolean'],
        ]);

        $validated['slug'] = Module::generateSlug($validated['name']);
        $validated['is_active'] = $request->boolean('is_active', true);

        $module = Module::create($validated);

        ActivityLog::log(
            auth()->user(),
            'create_module',
            $module,
            'Created new module: ' . $module->name
        );

        return redirect()->route('admin.modules.index')
            ->with('success', 'Module created successfully.');
    }

    /**
     * Show the form for editing a module.
     */
    public function edit(Module $module): View
    {
        $parents = Module::whereNull('parent_id')
            ->where('id', '!=', $module->id)
            ->with(['children' => function($query) use ($module) {
                $query->where('id', '!=', $module->id)
                    ->orderBy('name')
                    ->with(['children' => function($subQuery) use ($module) {
                        $subQuery->where('id', '!=', $module->id)->orderBy('name');
                    }]);
            }])
            ->orderBy('name')
            ->get();

        return view('admin.modules.edit', [
            'module' => $module,
            'parents' => $parents,
        ]);
    }

    /**
     * Update the specified module in storage.
     */
    public function update(Request $request, Module $module): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'parent_id' => ['nullable', 'exists:modules,id'],
            'order_number' => ['nullable', 'integer'],
            'is_active' => ['boolean'],
        ]);

        $validated['slug'] = Module::generateSlug($validated['name']);
        $validated['is_active'] = $request->boolean('is_active', true);

        $module->update($validated);

        ActivityLog::log(
            auth()->user(),
            'update_module',
            $module,
            'Updated module: ' . $module->name
        );

        return redirect()->route('admin.modules.index')
            ->with('success', 'Module updated successfully.');
    }

    /**
     * Remove the specified module from storage.
     */
    public function destroy(Module $module): RedirectResponse
    {
        ActivityLog::log(
            auth()->user(),
            'delete_module',
            $module,
            'Deleted module: ' . $module->name
        );

        $module->delete();

        return redirect()->route('admin.modules.index')
            ->with('success', 'Module deleted successfully.');
    }
}
