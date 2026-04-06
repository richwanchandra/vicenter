<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Module;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ActivityLogController extends Controller
{
    public function index(Request $request): View
    {
        $query = ActivityLog::with(['user', 'module'])->latest();

        if ($request->filled('user_id')) {
            $query->where('user_id', (int) $request->input('user_id'));
        }

        if ($request->filled('module_id')) {
            $query->where('module_id', (int) $request->input('module_id'));
        }

        if ($request->filled('action')) {
            $query->where('action', 'like', '%' . $request->input('action') . '%');
        }

        $logs = $query->paginate(20)->withQueryString();
        $users = User::orderBy('name')->get();
        $modules = Module::orderBy('name')->get();

        return view('admin.activity_logs.index', [
            'logs' => $logs,
            'users' => $users,
            'modules' => $modules,
        ]);
    }
}
