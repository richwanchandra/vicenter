<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Module;
use App\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RoleController extends Controller
{
    public function index(): View
    {
        $roles = Role::withCount('users')->with('users')->orderBy('name')->get();
        $users = \App\Models\User::orderBy('name')->get();
        $moduleUserCounts = DB::table('modules')
            ->leftJoin('role_module_access', 'modules.id', '=', 'role_module_access.module_id')
            ->leftJoin('user_roles', 'role_module_access.role_id', '=', 'user_roles.role_id')
            ->select('modules.id', DB::raw('COUNT(DISTINCT user_roles.user_id) as user_count'))
            ->groupBy('modules.id')
            ->pluck('user_count', 'modules.id');

        return view('admin.roles.index', [
            'roles' => $roles,
            'users' => $users,
            'moduleUserCounts' => $moduleUserCounts,
        ]);
    }

    public function create(): View
    {
        $modules = Module::whereNull('parent_id')
            ->where('is_active', true)
            ->orderBy('order_number')
            ->with([
                'children' => function ($q) {
                    $q->orderBy('order_number')
                      ->withCount('contents')
                      ->with([
                          'children' => function ($qq) {
                              $qq->orderBy('order_number')
                                 ->withCount('contents')
                                 ->with([
                                     'children' => function ($qqq) {
                                         $qqq->orderBy('order_number')
                                             ->withCount('contents');
                                     },
                                     'contents:id,module_id,title',
                                 ]);
                          },
                          'contents:id,module_id,title',
                      ]);
                },
                'contents:id,module_id,title',
            ])
            ->withCount('contents')
            ->get();

        return view('admin.roles.create', [
            'modules' => $modules,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:roles,name'],
            'description' => ['nullable', 'string', 'max:500'],
            'modules' => ['array'],
            'modules.*' => ['exists:modules,id'],
        ]);

        $role = Role::create([
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
        ]);

        $role->modules()->sync($validated['modules'] ?? []);

        ActivityLog::log(Auth::user(), 'create_role', null, 'Created role: '.$role->name);

        return redirect()->route('admin.roles.index')->with('success', 'Role created.');
    }

    public function edit(Role $role): View
    {
        $modules = Module::whereNull('parent_id')
            ->where('is_active', true)
            ->orderBy('order_number')
            ->with([
                'children' => function ($q) {
                    $q->orderBy('order_number')
                      ->withCount('contents')
                      ->with([
                          'children' => function ($qq) {
                              $qq->orderBy('order_number')
                                 ->withCount('contents')
                                 ->with([
                                     'children' => function ($qqq) {
                                         $qqq->orderBy('order_number')
                                             ->withCount('contents');
                                     },
                                     'contents:id,module_id,title',
                                 ]);
                          },
                          'contents:id,module_id,title',
                      ]);
                },
                'contents:id,module_id,title',
            ])
            ->withCount('contents')
            ->get();
        $selected = $role->modules()->pluck('modules.id')->toArray();

        return view('admin.roles.edit', [
            'role' => $role,
            'modules' => $modules,
            'selected' => $selected,
        ]);
    }

    public function update(Request $request, Role $role): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:roles,name,'.$role->id],
            'description' => ['nullable', 'string', 'max:500'],
            'modules' => ['array'],
            'modules.*' => ['exists:modules,id'],
        ]);

        $role->update([
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
        ]);

        $role->modules()->sync($validated['modules'] ?? []);

        ActivityLog::log(Auth::user(), 'update_role', null, 'Updated role: '.$role->name);

        return redirect()->route('admin.roles.index')->with('success', 'Role updated.');
    }

    public function destroy(Role $role): RedirectResponse
    {
        $name = $role->name;
        $role->modules()->detach();
        $role->users()->detach();
        $role->delete();

        ActivityLog::log(Auth::user(), 'delete_role', null, 'Deleted role: '.$name);

        return redirect()->route('admin.roles.index')->with('success', 'Role deleted.');
    }
}
