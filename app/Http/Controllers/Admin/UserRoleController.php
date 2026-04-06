<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserRoleController extends Controller
{
    public function index(): View
    {
        $users = User::orderBy('name')->with('roles')->get();

        return view('admin.user_roles.index', [
            'users' => $users,
        ]);
    }

    public function edit(User $user): View
    {
        $roles = Role::orderBy('name')->get();
        $selected = $user->roles()->pluck('roles.id')->toArray();

        return view('admin.user_roles.edit', [
            'user' => $user,
            'roles' => $roles,
            'selected' => $selected,
        ]);
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'roles' => ['array'],
            'roles.*' => ['exists:roles,id'],
        ]);

        $user->roles()->sync($validated['roles'] ?? []);

        ActivityLog::log(Auth::user(), 'update_user_roles', null, 'Updated roles for user: '.$user->name);

        Cache::forget('user:'.$user->id.':module_ids');

        return redirect()->route('admin.user-roles.index')->with('success', 'User roles updated.');
    }

    public function assign(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'user_id' => ['required', 'exists:users,id'],
            'role_id' => ['required', 'exists:roles,id'],
        ]);

        $user = User::findOrFail($validated['user_id']);
        $role = Role::findOrFail($validated['role_id']);

        $user->roles()->syncWithoutDetaching([$role->id]);

        ActivityLog::log(Auth::user(), 'assign_user_role', null, 'Assigned role '.$role->name.' to user: '.$user->name);

        Cache::forget('user:'.$user->id.':module_ids');

        return back()->with('success', 'Role assigned to user.');
    }
}
