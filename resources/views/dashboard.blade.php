@extends('layouts.app')

@section('page_title', 'Dashboard')

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        @foreach($modules as $module)
            <a href="{{ route('module.show', $module->slug) }}" class="group">
                <div class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition cursor-pointer border border-gray-200 h-full">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-blue-100 rounded text-blue-600 flex items-center justify-center">
                            <i class="fas fa-folder text-lg"></i>
                        </div>
                        <h3 class="ml-4 text-lg font-semibold text-gray-800 group-hover:text-blue-600 transition">{{ $module->name }}</h3>
                    </div>
                    <p class="text-sm text-gray-600">
                        @php
                            $contentCount = $module->contents()->where('status', 'publish')->count();
                        @endphp
                        {{ $contentCount }} {{ $contentCount === 1 ? 'item' : 'items' }}
                    </p>
                </div>
            </a>
        @endforeach
    </div>

    @if($modules->isEmpty())
        <div class="bg-white p-12 rounded-lg shadow text-center">
            <i class="fas fa-inbox text-4xl text-gray-300 mb-4"></i>
            <p class="text-gray-500 text-lg">No modules assigned to you yet.</p>
            <p class="text-gray-400 text-sm mt-2">Please contact your administrator.</p>
        </div>
    @endif
@endsection
