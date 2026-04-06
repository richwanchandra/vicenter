@extends('layouts.app')

@section('page_title', 'Roles')

@section('header_actions')
    <a href="{{ route('admin.roles.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
        <i class="fas fa-plus mr-2"></i>Add Role
    </a>
    <a href="{{ route('admin.user-roles.index') }}" class="bg-teal-600 text-white px-4 py-2 rounded hover:bg-teal-700 transition">
        <i class="fas fa-user-lock mr-2"></i>Assign User Roles
    </a>
@endsection

@section('content')
    <div class="bg-white rounded-lg shadow border border-gray-200 table-responsive-force-scroll">
        <table class="w-full min-w-[960px] responsive-table">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Name</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Description</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Users with Access</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Assign to User</th>
                    <th class="px-6 py-3 text-right text-sm font-semibold text-gray-700">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($roles as $role)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 text-sm text-gray-800" data-label="Name">{{ $role->name }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600" data-label="Description">{{ $role->description }}</td>
                        <td class="px-6 py-4 text-sm" data-label="Users with Access">
                            <span class="inline-block px-2 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800 mr-2">
                                {{ $role->users_count }} users
                            </span>
                            @if($role->users->count() > 0)
                                <div class="mt-2 text-xs text-gray-700 max-h-28 overflow-y-auto border border-gray-200 rounded p-2 bg-gray-50">
                                    @foreach($role->users as $u)
                                        <div class="flex items-center justify-between">
                                            <span>{{ $u->name }}</span>
                                            <span class="text-gray-500">{{ $u->email }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm" data-label="Assign to User">
                            <form action="{{ route('admin.user-roles.assign') }}" method="POST" class="flex items-center gap-2">
                                @csrf
                                <input type="hidden" name="role_id" value="{{ $role->id }}">
                                <select name="user_id" class="border border-gray-300 rounded px-2 py-1 text-sm">
                                    <option value="">Select user</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                                <button type="submit" class="bg-teal-600 text-white px-3 py-1 rounded hover:bg-teal-700">
                                    Give Access
                                </button>
                            </form>
                        </td>
                        <td class="px-6 py-4 text-right text-sm space-x-3" data-label="Actions">
                            <a href="{{ route('admin.roles.edit', $role) }}" class="text-blue-600 hover:text-blue-700">
                                <i class="fas fa-edit mr-1"></i>Edit
                            </a>
                            <form action="{{ route('admin.roles.destroy', $role) }}" method="POST" class="inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-700">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-8 text-center text-gray-500">
                            No roles found
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
