@extends('layouts.app')

@section('page_title')
    <div class="flex items-center">
        <a href="{{ route('dashboard') }}" class="text-blue-600 hover:text-blue-700 mr-2">
            <i class="fas fa-arrow-left"></i>
        </a>
        {{ $module->name }}
    </div>
@endsection

@section('content')
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2">
            @if($contents->isNotEmpty())
                <div class="space-y-6">
                    @foreach($contents as $content)
                        <div class="bg-white p-6 rounded-lg shadow border border-gray-200">
                            <h3 class="text-2xl font-bold text-gray-800 mb-2">{{ $content->title }}</h3>
                            <div class="flex items-center text-sm text-gray-500 mb-4">
                                <i class="fas fa-user mr-2"></i>
                                {{ $content->creator->name }}
                                <i class="fas fa-calendar ml-4 mr-2"></i>
                                {{ $content->created_at->format('d M Y') }}
                            </div>
                            <div class="prose max-w-none text-gray-700">
                                {!! $content->content !!}
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="bg-white p-12 rounded-lg shadow text-center border border-gray-200">
                    <i class="fas fa-file-alt text-4xl text-gray-300 mb-4"></i>
                    <p class="text-gray-500 text-lg">No content available for this module.</p>
                </div>
            @endif
        </div>

        <!-- Sidebar -->
        <aside>
            @if($childModules->isNotEmpty())
                <div class="bg-white p-6 rounded-lg shadow border border-gray-200">
                    <h4 class="text-lg font-semibold mb-4 text-gray-800">Sub Modules</h4>
                    <ul class="space-y-2">
                        @foreach($childModules as $child)
                            <li>
                                <a href="{{ route('module.show', $child->slug) }}" class="text-blue-600 hover:text-blue-700 hover:underline flex items-center">
                                    <i class="fas fa-angle-right mr-2 text-sm"></i>
                                    {{ $child->name }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </aside>
    </div>
@endsection
