@extends('layouts.user')

@section('title', 'Dashboard - VIMS')

@section('content')
    <div class="vims-dashboard-hero">
        <h1>Welcome, {{ auth()->user()->name }}</h1>
        <p>VILO Internal Operation Handbook — Select a module to get started</p>
    </div>

    @if($moduleTree->isNotEmpty())
        <div class="vims-module-grid">
            @php $colorIndex = 0;
            $colors = ['', 'alt1', 'alt2', 'alt3', 'alt4', 'alt5']; @endphp
            @foreach($moduleTree as $module)
                <a href="{{ route('module.show', $module->slug) }}" class="vims-module-card" id="module-card-{{ $module->slug }}">
                    <div class="vims-module-card-header">
                        <div class="vims-module-card-icon {{ $colors[$colorIndex % count($colors)] }}">
                            <i class="fas fa-book-open"></i>
                        </div>
                        <span class="vims-module-card-title">{{ $module->name }}</span>
                    </div>
                    <span class="vims-module-card-desc">
                        @php
                            $childCount = $module->children ? $module->children->count() : 0;
                        @endphp
                        {{ $childCount }} {{ $childCount === 1 ? 'sub-module' : 'sub-modules' }}
                    </span>
                </a>
                @php $colorIndex++; @endphp
            @endforeach
        </div>
    @else
        <div class="vims-empty">
            <i class="fas fa-inbox"></i>
            <p>No modules assigned to you yet.</p>
            <p style="font-size:0.85rem;margin-top:0.5rem;color:var(--vims-text-muted)">Please contact your administrator.</p>
        </div>
    @endif
@endsection