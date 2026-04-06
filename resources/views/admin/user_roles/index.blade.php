@extends('layouts.app')

@section('page_title', 'User Roles')

@section('content')
    <div class="bg-white rounded-lg shadow border border-gray-200 table-responsive-force-scroll">
        <table class="w-full min-w-[640px]">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">User Name</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Email</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Roles</th>
                    <th class="px-6 py-3 text-right text-sm font-semibold text-gray-700">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($users as $user)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 text-sm text-gray-800">{{ $user->name }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $user->email }}</td>
                        <td class="px-6 py-4 text-sm">
                            @foreach($user->roles as $role)
                                <span class="inline-block px-2 py-1 rounded-full text-xs font-semibold bg-purple-100 text-purple-800 mr-1 mb-1">
                                    {{ $role->name }}
                                </span>
                            @endforeach
                        </td>
                        <td class="px-6 py-4 text-right text-sm">
                            <a href="{{ route('admin.user-roles.edit', $user) }}" class="text-blue-600 hover:text-blue-700">
                                <i class="fas fa-edit mr-1"></i>Edit
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-8 text-center text-gray-500">
                            No users found
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
