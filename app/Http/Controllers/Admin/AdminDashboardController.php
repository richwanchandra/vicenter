<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Module;
use App\Models\User;
use Illuminate\View\View;

class AdminDashboardController extends Controller
{
    /**
     * Display admin dashboard.
     */
    public function index(): View
    {
        $totalUsers = User::count();
        $totalModules = Module::count();
        $totalAdmins = User::where('role', '!=', 'user')->count();

        return view('admin.dashboard', [
            'totalUsers' => $totalUsers,
            'totalModules' => $totalModules,
            'totalAdmins' => $totalAdmins,
        ]);
    }
}
