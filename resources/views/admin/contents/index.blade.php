@extends('layouts.app')

@section('page_title', 'Contents - ' . $module->name)

@section('header_actions')
    <a href="{{ route('admin.modules.index') }}" class="text-gray-600 hover:text-gray-700 mr-2">
        <i class="fas fa-arrow-left"></i>
    </a>
    <a href="{{ route('admin.modules.contents.create', $module) }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
        <i class="fas fa-plus mr-2"></i>Add Content
    </a>
@endsection

@section('content')
    @if($contents->isEmpty())
        <div class="bg-white p-12 rounded-lg shadow text-center border border-gray-200">
            <i class="fas fa-file-alt text-4xl text-gray-300 mb-4"></i>
            <p class="text-gray-500 text-lg">No content yet.</p>
            <a href="{{ route('admin.modules.contents.create', $module) }}" class="inline-block mt-4 bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Create First Content
            </a>
        </div>
    @else
        <div class="bg-white rounded-lg shadow border border-gray-200 table-responsive-force-scroll">
            <table class="w-full min-w-[640px]">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Title</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Status</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Created By</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Updated</th>
                        <th class="px-6 py-3 text-right text-sm font-semibold text-gray-700">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($contents as $content)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 text-sm text-gray-800">{{ $content->title }}</td>
                            <td class="px-6 py-4 text-sm">
                                <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold
                                    {{ $content->isPublished() ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                    {{ ucfirst($content->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $content->creator?->name ?? '-' }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">
                                {{ ($content->updated_at ?? $content->created_at)?->format('d M Y H:i') ?? '-' }}
                            </td>
                            <td class="px-6 py-4 text-right text-sm space-x-3">
                                @if($content->isPublished())
                                    <form action="{{ route('admin.modules.contents.draft', [$module, $content]) }}" method="POST" style="display:inline-block;">
                                        @csrf
                                        <button type="submit" class="text-yellow-600 hover:text-yellow-700" title="Save as Draft">
                                            <i class="fas fa-times-circle"></i>
                                        </button>
                                    </form>
                                @else
                                    <form action="{{ route('admin.modules.contents.publish', [$module, $content]) }}" method="POST" style="display:inline-block;">
                                        @csrf
                                        <button type="submit" class="text-green-600 hover:text-green-700" title="Publish">
                                            <i class="fas fa-check-circle"></i>
                                        </button>
                                    </form>
                                @endif
                                <a href="{{ route('admin.modules.contents.edit', [$module, $content]) }}" class="text-blue-600 hover:text-blue-700">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.modules.contents.destroy', [$module, $content]) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Are you sure?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-700">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
@endsection
