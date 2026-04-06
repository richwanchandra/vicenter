@php
    $depth = $depth ?? 0;
    $indent = $depth * 16;
@endphp

<div class="pl-{{ $depth ? ($depth > 1 ? 2 : 3) : 0 }} sm:pl-{{ $depth ? 4 : 0 }} {{ $depth > 0 ? 'border-l border-gray-100' : '' }} mb-4 min-w-0">
    <div class="flex flex-wrap sm:flex-nowrap items-center justify-between gap-2 min-w-0">
        <div class="min-w-0 flex-1">
            <h4 class="text-sm font-semibold text-gray-800 truncate sm:whitespace-normal" title="{{ $module->name }}">{{ $module->name }}</h4>
        </div>
        <div class="flex items-center gap-1.5 shrink-0 ml-auto bg-white/80 sm:bg-transparent px-1 rounded">
            <a href="{{ route('admin.modules.contents.index', $module) }}" class="text-green-600 hover:text-green-700 p-1" title="Manage Content">
                <i class="fas fa-file-alt"></i>
            </a>
            <a href="{{ route('admin.modules.edit', $module) }}" class="text-blue-600 hover:text-blue-700 p-1" title="Edit">
                <i class="fas fa-edit"></i>
            </a>
            <form action="{{ route('admin.modules.destroy', $module) }}" method="POST" onsubmit="return confirm('Are you sure?')" class="m-0">
                @csrf @method('DELETE')
                <button type="submit" class="text-red-600 hover:text-red-700 p-1" title="Delete">
                    <i class="fas fa-trash"></i>
                </button>
            </form>
        </div>
    </div>

    @if(isset($module->contents) && $module->contents->count() > 0)
        <ul class="mt-2 space-y-1 pl-1 sm:pl-2">
            @foreach($module->contents as $c)
                <li class="flex items-center gap-1.5 text-sm text-gray-700 min-w-0">
                    <i class="fas fa-file-alt text-gray-300 w-3 text-center shrink-0"></i>
                    <span class="flex-1 truncate sm:whitespace-normal text-xs leading-tight">{{ $c->title }}</span>
                    <span class="text-[9px] sm:text-[10px] px-1.5 py-0.5 rounded shrink-0 {{ $c->status === 'publish' ? 'bg-emerald-50 text-emerald-600' : 'bg-yellow-50 text-yellow-600' }}">
                        {{ ucfirst($c->status) }}
                    </span>
                </li>
            @endforeach
        </ul>
    @endif

    @if($module->children && $module->children->count() > 0)
        <div class="mt-3 ml-2 sm:ml-4 border-l border-gray-100 pl-2 sm:pl-4">
            @foreach($module->children as $child)
                @include('admin.modules._module_tree', ['module' => $child, 'depth' => ($depth + 1), 'moduleUserCounts' => $moduleUserCounts ?? null])
            @endforeach
        </div>
    @endif
</div>
