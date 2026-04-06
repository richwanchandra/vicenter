@extends('layouts.app')

@section('page_title', 'Modules')

@section('header_actions')
    <a href="{{ route('admin.modules.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
        <i class="fas fa-plus mr-2"></i>Add Module
    </a>
@endsection

@section('content')
    <div class="bg-white rounded-lg shadow border border-gray-200">
        <div class="p-3 sm:p-6">
            <div class="grid grid-cols-1 xl:grid-cols-2 gap-4 sm:gap-8">
                @forelse($modules as $module)
                    <div class="border border-gray-200 rounded-lg p-4 flex flex-col min-w-0 overflow-hidden">
                        <div class="flex items-center justify-between mb-3 gap-4">
                            <div class="min-w-0 flex-1">
                                <h3 class="font-bold text-blue-600 truncate" title="{{ $module->name }}">{{ $module->name }}</h3>
                            </div>
                            <div class="flex items-center gap-2 shrink-0">
                                <a href="{{ route('admin.modules.contents.index', $module) }}" class="text-green-600 hover:text-green-700" title="Manage Content">
                                    <i class="fas fa-file-edit"></i>
                                </a>
                                <a href="{{ route('admin.modules.edit', $module) }}" class="text-blue-600 hover:text-blue-700" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.modules.destroy', $module) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-700" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                        @include('admin.modules._module_tree', ['module' => $module, 'depth' => 0, 'moduleUserCounts' => $moduleUserCounts])
                    </div>
                @empty
                    <div class="col-span-2 text-center text-gray-500 py-8">
                        No modules found
                    </div>
                @endforelse
            </div>
        </div>
    </div>
@endsection
