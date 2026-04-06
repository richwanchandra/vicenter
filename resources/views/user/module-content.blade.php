@extends('layouts.user')

@section('title', $module->name . ' - Vilo Internal Center')

@section('breadcrumb')
    <ul class="vims-breadcrumb-list">
        <li>
            <a href="{{ route('dashboard') }}"><i class="fas fa-home"></i> Home</a>
        </li>
        @foreach($breadcrumbs as $index => $crumb)
            <li>
                <span class="vims-breadcrumb-separator"><i class="fas fa-chevron-right"></i></span>
            </li>
            <li>
                @if($index < count($breadcrumbs) - 1)
                    <a href="{{ route('module.show', $crumb['slug']) }}">{{ $crumb['name'] }}</a>
                @else
                    <span class="current">{{ $crumb['name'] }}</span>
                @endif
            </li>
        @endforeach
    </ul>
@endsection

@section('content')
    <div class="vims-unified-content">
        @include('partials.module-with-children', ['module' => $module, 'level' => 1])
    </div>
@endsection