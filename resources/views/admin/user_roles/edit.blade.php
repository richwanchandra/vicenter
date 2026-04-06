@extends('layouts.app')

@section('page_title', 'Edit User Roles')

@section('content')
    <form action="{{ route('admin.user-roles.update', $user) }}" method="POST" class="bg-white rounded-lg shadow border border-gray-200 p-6">
        @csrf @method('PUT')

        <div class="mb-4">
            <p class="text-sm font-semibold text-gray-700 mb-1">User</p>
            <p class="text-lg text-gray-800">{{ $user->name }} <span class="text-gray-500 text-sm">({{ $user->email }})</span></p>
        </div>

        <div class="mb-6">
            <label class="block text-sm font-semibold text-gray-700 mb-2">Roles</label>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                @foreach($roles as $role)
                    <label class="flex items-center space-x-2">
                        <input type="checkbox" name="roles[]" value="{{ $role->id }}" class="rounded"
                               @checked(in_array($role->id, $selected))>
                        <span>{{ $role->name }}</span>
                    </label>
                @endforeach
            </div>
        </div>

        <div class="flex space-x-3">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Update</button>
            <a href="{{ route('admin.user-roles.index') }}" class="px-4 py-2 border border-gray-300 rounded">Cancel</a>
        </div>
    </form>
@endsection
