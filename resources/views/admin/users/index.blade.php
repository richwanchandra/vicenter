@extends('layouts.app')

@section('page_title', 'Users')

@section('header_actions')
    @if(auth()->user()->isSuperAdmin())
        <a href="{{ route('admin.users.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
            <i class="fas fa-user-plus mr-2"></i>Add User
        </a>
    @endif
@endsection

@section('content')
    <div class="bg-white rounded-lg shadow overflow-hidden border border-gray-200">
        <table class="w-full responsive-table">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Name</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Email</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Role</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Joined</th>
                    @if(auth()->user()->isSuperAdmin())
                        <th class="px-6 py-3 text-right text-sm font-semibold text-gray-700">Actions</th>
                    @endif
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($users as $user)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 text-sm text-gray-800" data-label="Name">{{ $user->name }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600" data-label="Email">{{ $user->email }}</td>
                        <td class="px-6 py-4 text-sm" data-label="Role">
                            <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold
                                @if($user->isSuperAdmin())
                                    bg-red-100 text-red-800
                                @elseif($user->isAdmin())
                                    bg-blue-100 text-blue-800
                                @else
                                    bg-gray-100 text-gray-800
                                @endif
                            ">
                                {{ ucfirst(str_replace('_', ' ', $user->role)) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600" data-label="Joined">{{ $user->created_at->format('d M Y') }}</td>
                        @if(auth()->user()->isSuperAdmin())
                            <td class="px-6 py-4 text-right text-sm space-x-2" data-label="Actions">
                                <a href="{{ route('admin.users.edit', $user) }}" class="text-blue-600 hover:text-blue-700">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Are you sure?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-700">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        @endif
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                            No users found
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
