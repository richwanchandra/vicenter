@extends('layouts.app')

@section('page_title', 'User Roles')

@section('content')
    <div class="bg-white rounded-lg shadow overflow-hidden border border-gray-200">
        <table class="w-full responsive-table">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">User</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Roles</th>
                    <th class="px-6 py-3 text-right text-sm font-semibold text-gray-700">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($users as $user)
                    <tr>
                        <td class="px-6 py-4" data-label="User">
                            <div class="text-sm font-semibold text-gray-800">{{ $user->name }}</div>
                            <div class="text-xs text-gray-500">{{ $user->email }}</div>
                        </td>
                        <td class="px-6 py-4" data-label="Roles">
                            <div class="flex flex-wrap gap-1">
                                @forelse($user->roles as $role)
                                    <span class="inline-block px-2 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-800">
                                        {{ $role->name }}
                                    </span>
                                @empty
                                    <span class="text-xs text-gray-500">No roles assigned</span>
                                @endforelse
                            </div>
                        </td>
                        <td class="px-6 py-4 text-right text-sm" data-label="Actions">
                            <a href="{{ route('admin.user-roles.edit', $user) }}" class="text-blue-600 hover:text-blue-700 font-semibold">
                                Edit Roles
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="px-6 py-8 text-center text-gray-500">
                            No users found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
