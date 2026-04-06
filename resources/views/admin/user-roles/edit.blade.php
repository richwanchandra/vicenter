@extends('layouts.app')

@section('page_title', 'Edit Roles for ' . $user->name)

@section('content')
    <div class="max-w-2xl mx-auto">
        <form action="{{ route('admin.user-roles.update', $user) }}" method="POST" class="bg-white rounded-lg shadow border border-gray-200 p-6">
            @csrf
            @method('PUT')

            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Roles</label>
                <div class="space-y-2">
                    @foreach($roles as $role)
                        <div class="flex items-center">
                            <input type="checkbox" name="roles[]" id="role-{{ $role->id }}" value="{{ $role->id }}" 
                                class="w-4 h-4 text-blue-600 rounded" {{ in_array($role->id, $selected) ? 'checked' : '' }}>
                            <label for="role-{{ $role->id }}" class="ml-2 text-sm text-gray-800">{{ $role->name }}</label>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="flex items-center gap-4 pt-4 border-t">
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">
                    Update Roles
                </button>
                <a href="{{ route('admin.user-roles.index') }}" class="text-gray-600 hover:text-gray-800">
                    Cancel
                </a>
            </div>
        </form>
    </div>
@endsection
