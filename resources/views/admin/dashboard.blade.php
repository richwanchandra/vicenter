@extends('layouts.app')

@section('page_title', 'Admin Dashboard')

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <!-- Total Users Card -->
        <div class="bg-white p-6 rounded-lg shadow border border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-semibold">Total Users</p>
                    <p class="text-4xl font-bold text-gray-800 mt-2">{{ $totalUsers }}</p>
                </div>
                <div class="w-16 h-16 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-users text-2xl text-blue-600"></i>
                </div>
            </div>
        </div>

        <!-- Total Modules Card -->
        <div class="bg-white p-6 rounded-lg shadow border border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-semibold">Total Modules</p>
                    <p class="text-4xl font-bold text-gray-800 mt-2">{{ $totalModules }}</p>
                </div>
                <div class="w-16 h-16 bg-green-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-folder text-2xl text-green-600"></i>
                </div>
            </div>
        </div>

        <!-- Admin Count Card -->
        <div class="bg-white p-6 rounded-lg shadow border border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-semibold">Admins</p>
                    <p class="text-4xl font-bold text-gray-800 mt-2">{{ $totalAdmins }}</p>
                </div>
                <div class="w-16 h-16 bg-purple-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-user-shield text-2xl text-purple-600"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white p-6 rounded-lg shadow border border-gray-200">
        <h3 class="text-xl font-semibold mb-4 text-gray-800">Quick Actions</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <a href="{{ route('user.home') }}"
                class="block p-4 border border-gray-300 rounded-lg hover:border-cyan-500 hover:bg-cyan-50 transition">
                <div class="flex items-center">
                    <i class="fas fa-home text-cyan-600 text-xl mr-3"></i>
                    <div>
                        <p class="font-semibold text-gray-800">Go to Home</p>
                        <p class="text-sm text-gray-600">Go to user home page</p>
                    </div>
                </div>
            </a>

            <a href="{{ route('admin.users.index') }}"
                class="block p-4 border border-gray-300 rounded-lg hover:border-blue-500 hover:bg-blue-50 transition">
                <div class="flex items-center">
                    <i class="fas fa-user-plus text-blue-600 text-xl mr-3"></i>
                    <div>
                        <p class="font-semibold text-gray-800">Manage Users</p>
                        <p class="text-sm text-gray-600">Create, edit or delete users</p>
                    </div>
                </div>
            </a>

            <a href="{{ route('admin.user-roles.index') }}"
                class="block p-4 border border-gray-300 rounded-lg hover:border-green-500 hover:bg-green-50 transition">
                <div class="flex items-center">
                    <i class="fas fa-lock text-green-600 text-xl mr-3"></i>
                    <div>
                        <p class="font-semibold text-gray-800">Employee Access</p>
                        <p class="text-sm text-gray-600">Assign roles to users</p>
                    </div>
                </div>
            </a>

            <a href="{{ route('admin.modules.index') }}"
                class="block p-4 border border-gray-300 rounded-lg hover:border-orange-500 hover:bg-orange-50 transition">
                <div class="flex items-center">
                    <i class="fas fa-file-edit text-orange-600 text-xl mr-3"></i>
                    <div>
                        <p class="font-semibold text-gray-800">Manage Content</p>
                        <p class="text-sm text-gray-600">Edit module contents</p>
                    </div>
                </div>
            </a>

            <a href="{{ route('admin.roles.index') }}"
                class="block p-4 border border-gray-300 rounded-lg hover:border-indigo-500 hover:bg-indigo-50 transition">
                <div class="flex items-center">
                    <i class="fas fa-shield-alt text-indigo-600 text-xl mr-3"></i>
                    <div>
                        <p class="font-semibold text-gray-800">Manage Roles</p>
                        <p class="text-sm text-gray-600">Define roles and module access</p>
                    </div>
                </div>
            </a>

            <a href="{{ route('admin.user-roles.index') }}"
                class="block p-4 border border-gray-300 rounded-lg hover:border-teal-500 hover:bg-teal-50 transition">
                <div class="flex items-center">
                    <i class="fas fa-user-lock text-teal-600 text-xl mr-3"></i>
                    <div>
                        <p class="font-semibold text-gray-800">Assign User Roles</p>
                        <p class="text-sm text-gray-600">Attach roles to users</p>
                    </div>
                </div>
            </a>
        </div>
    </div>
@endsection
