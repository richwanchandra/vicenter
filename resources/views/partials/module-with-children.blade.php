<div class="vims-content-card" id="module-{{ $module->slug }}" style="margin-bottom: 2rem; scroll-margin-top: 120px;">
    @if($level === 1)
        <h1>{{ $module->name }}</h1>
    @else
        <h2 style="margin-top: 0; padding-bottom: 0.5rem; border-bottom: 1px solid var(--vims-border); margin-bottom: 1.5rem;">
            {{ $module->name }}
        </h2>
    @endif

    {{-- Module Contents --}}
    @if($module->contents->isNotEmpty())
        <div class="vims-module-contents">
            @foreach($module->contents as $content)
                <article class="vims-prose" id="content-{{ $content->id }}">
                    @if($module->contents->count() > 1)
                        <h3 style="color: var(--vims-gold); margin-bottom: 1rem;">{{ $content->title }}</h3>
                    @endif
                    <div class="content-body">
                        {!! $content->content !!}
                    </div>
                </article>
                @if(!$loop->last)
                    <hr style="border:none; border-top: 1px dashed var(--vims-border); margin: 2rem 0;">
                @endif
            @endforeach
        </div>
    @elseif($module->children->isEmpty())
        <div class="vims-empty" style="padding: 1rem 0">
            <p style="font-style: italic; color: var(--vims-text-muted);">No content available for this section.</p>
        </div>
    @endif
</div>

{{-- Render Children Recursively --}}
@if($module->children->isNotEmpty())
    <div class="vims-children-content" style="margin-left: {{ $level * 0.5 }}rem;">
        @foreach($module->children as $child)
            @include('partials.module-with-children', ['module' => $child, 'level' => $level + 1])
        @endforeach
    </div>
@endif
