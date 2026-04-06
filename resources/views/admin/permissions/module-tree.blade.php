<div class="py-1">
    @if($module->children->count() > 0)
        <details open class="group">
            <summary class="flex items-center cursor-pointer list-none py-1">
                <span class="mr-2 transform transition-transform group-open:rotate-90">
                    <i class="fas fa-chevron-right text-xs text-gray-400 font-bold w-4 text-center"></i>
                </span>
                <input type="checkbox" name="modules[]" value="{{ $module->id }}"
                    id="module_{{ $module->id }}"
                    data-depth="{{ $depth }}"
                    data-parent-id="{{ $module->parent_id }}"
                    class="w-4 h-4 text-blue-600 rounded"
                    {{ in_array($module->id, $selected ?? []) ? 'checked' : '' }}
                    onclick="event.stopPropagation();">
                <label for="module_{{ $module->id }}" class="ml-2 text-sm font-medium text-gray-800 cursor-pointer flex-1" onclick="event.stopPropagation();">
                    {{ $module->name }}
                </label>
            </summary>
            <div class="mt-1 border-l-2 ml-2 pl-4 border-gray-100">
                @foreach($module->children as $child)
                    @include('admin.permissions.module-tree', ['module' => $child, 'depth' => $depth + 1, 'selected' => $selected ?? []])
                @endforeach
            </div>
        </details>
    @else
        <div class="flex items-center py-1 pl-6">
            <input type="checkbox" name="modules[]" value="{{ $module->id }}"
                id="module_{{ $module->id }}"
                data-depth="{{ $depth }}"
                data-parent-id="{{ $module->parent_id }}"
                class="w-4 h-4 text-gray-400 rounded"
                {{ in_array($module->id, $selected ?? []) ? 'checked' : '' }}>
            <label for="module_{{ $module->id }}" class="ml-2 text-sm text-gray-600 cursor-pointer flex-1">
                {{ $module->name }}
            </label>
        </div>
    @endif
</div>
