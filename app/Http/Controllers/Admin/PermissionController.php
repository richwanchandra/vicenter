<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Module;
use App\Models\User;
use App\Models\UserModulePermission;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PermissionController extends Controller
{
    /**
     * Display a listing of users for permission management.
     */
    public function index(): View
    {
        $users = User::where('role', 'user')->orderBy('name')->get();

        return view('admin.permissions.index', [
            'users' => $users,
        ]);
    }

    /**
     * Show the form for editing permissions for a user.
     */
    public function edit(User $user): View
    {
        if ($user->isSuperAdmin() && auth()->user()->id !== $user->id) {
            abort(403);
        }

        // Get all modules organized hierarchically
        $modules = Module::where('parent_id', null)
            ->orderBy('order_number')
            ->with('children')
            ->get();

        // Get user's current permissions
        $selected = $user->modules()->pluck('module_id')->toArray();

        return view('admin.permissions.edit', [
            'user' => $user,
            'modules' => $modules,
            'selected' => $selected,
        ]);
    }

    /**
     * Update permissions for a user.
     */
    public function update(Request $request, User $user): RedirectResponse
    {
        if ($user->isSuperAdmin() && auth()->user()->id !== $user->id) {
            abort(403);
        }

        $validated = $request->validate([
            'modules' => ['array'],
            'modules.*' => ['exists:modules,id'],
        ]);

        $moduleIds = $validated['modules'] ?? [];

        // Clear existing permissions
        $user->modules()->detach();

        // Grant new permissions
        foreach ($moduleIds as $moduleId) {
            $module = Module::find($moduleId);
            UserModulePermission::grantPermission($user, $module);
        }

        ActivityLog::log(
            auth()->user(),
            'update_permissions',
            null,
            'Updated permissions for user: ' . $user->name
        );

        Cache::forget('user:'.$user->id.':module_ids');

        return redirect()->route('admin.permissions.index')
            ->with('success', 'Permissions updated successfully.');
    }

    /**
     * Clone permissions from one user to another.
     */
    public function clone(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'from_user_id' => ['required', 'exists:users,id'],
        ]);

        $fromUser = User::find($validated['from_user_id']);

        // Get permissions from source user
        $sourcePermissions = $fromUser->modules()->pluck('module_id')->toArray();

        // Clear existing permissions
        $user->modules()->detach();

        // Grant cloned permissions
        foreach ($sourcePermissions as $moduleId) {
            $module = Module::find($moduleId);
            UserModulePermission::grantPermission($user, $module);
        }

        ActivityLog::log(
            auth()->user(),
            'clone_permissions',
            null,
            "Cloned permissions from {$fromUser->name} to {$user->name}"
        );

        Cache::forget('user:'.$user->id.':module_ids');

        return redirect()->route('admin.permissions.index')
            ->with('success', "Permissions cloned from {$fromUser->name}.");
    }
}
