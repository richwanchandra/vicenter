@extends('layouts.app')

@section('page_title', 'Edit Module')

@section('content')
    <div class="max-w-4xl mx-auto">
        <div class="bg-white p-6 rounded-lg shadow border border-gray-200">
            <form method="POST" action="{{ route('admin.modules.update', $module) }}" class="space-y-4">
                @csrf @method('PUT')

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Module Name</label>
                    <input type="text" name="name" value="{{ old('name', $module->name) }}" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('name') border-red-500 @enderror">
                    @error('name') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Parent Module</label>
                    <select name="parent_id"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('parent_id') border-red-500 @enderror">
                        <option value="">Root Module</option>
                        @foreach($parents as $parent)
                            <option value="{{ $parent->id }}" {{ old('parent_id', $module->parent_id) == $parent->id ? 'selected' : '' }}>
                                {{ $parent->name }}
                            </option>
                            @foreach($parent->children as $child)
                                <option value="{{ $child->id }}" {{ old('parent_id', $module->parent_id) == $child->id ? 'selected' : '' }}>
                                    &nbsp;&nbsp;&nbsp;&nbsp;↳ {{ $child->name }}
                                </option>
                                @foreach($child->children as $subChild)
                                    <option value="{{ $subChild->id }}" {{ old('parent_id', $module->parent_id) == $subChild->id ? 'selected' : '' }}>
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;↳ {{ $subChild->name }}
                                    </option>
                                @endforeach
                            @endforeach
                        @endforeach
                    </select>
                    @error('parent_id') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Order Number</label>
                    <input type="number" name="order_number" value="{{ old('order_number', $module->order_number) }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('order_number') border-red-500 @enderror">
                    @error('order_number') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="flex items-center">
                    <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $module->is_active) ? 'checked' : '' }}
                        class="w-4 h-4 text-blue-600 rounded">
                    <label for="is_active" class="ml-2 text-sm font-semibold text-gray-700">Active</label>
                </div>

                <div class="flex gap-4 pt-4">
                    <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 transition">
                        Update Module
                    </button>
                    <a href="{{ route('admin.modules.index') }}" class="bg-gray-300 text-gray-700 px-6 py-2 rounded hover:bg-gray-400 transition">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
