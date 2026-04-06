@extends('layouts.app')

@section('page_title', 'Edit Role')

@section('content')
    <form action="{{ route('admin.roles.update', $role) }}" method="POST" class="bg-white rounded-lg shadow border border-gray-200 p-4 sm:p-6">
        @csrf @method('PUT')

        <div class="space-y-6">
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Name</label>
                <input type="text" name="name" value="{{ $role->name }}" class="w-full md:w-1/2 border border-gray-300 rounded px-3 py-2" required>
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Description</label>
                <input type="text" name="description" value="{{ $role->description }}" class="w-full md:w-1/2 border border-gray-300 rounded px-3 py-2">
            </div>
        </div>

        <div class="mt-6 mb-6">
            <label class="block text-sm font-semibold text-gray-700 mb-2">Modules</label>
            <div class="mb-3 flex flex-wrap items-center gap-2">
                <input id="perm-search" type="text" placeholder="Search modules..." class="border border-gray-300 rounded px-3 py-1.5 text-sm w-full sm:w-64">
                <button type="button" id="perm-expand" class="text-sm bg-gray-100 px-3 py-1 rounded hover:bg-gray-200">Expand all</button>
                <button type="button" id="perm-collapse" class="text-sm bg-gray-100 px-3 py-1 rounded hover:bg-gray-200">Collapse all</button>
            </div>
            <div id="perm-tree" class="space-y-1 border border-gray-200 rounded p-4 max-h-[60vh] overflow-y-auto">
                @foreach($modules as $module)
                    @include('admin.permissions.module-tree', ['module' => $module, 'depth' => 0, 'selected' => $selected])
                @endforeach
            </div>
        </div>

        <div class="flex flex-col sm:flex-row sm:items-center gap-3 pt-4 border-t">
            <button type="submit" class="w-full sm:w-auto bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">Update</button>
            <a href="{{ route('admin.roles.index') }}" class="w-full sm:w-auto text-center px-6 py-2 border border-gray-300 rounded hover:bg-gray-100">Cancel</a>
        </div>
    </form>
    <script>
        (function(){
            const checkboxes = document.querySelectorAll('input[name="modules[]"]');
            function checkAncestors(checkbox) {
                const parentId = checkbox.dataset.parentId;
                if (parentId && parentId !== '') {
                    const parentCheckbox = document.getElementById(`module_${parentId}`);
                    if (parentCheckbox) {
                        parentCheckbox.checked = true;
                        checkAncestors(parentCheckbox);
                    }
                }
            }
            function checkDescendants(parentId, isChecked) {
                checkboxes.forEach(cb => {
                    if (cb.dataset.parentId === parentId) {
                        cb.checked = isChecked;
                        checkDescendants(cb.value, isChecked);
                    }
                });
            }
            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    const isChecked = this.checked;
                    const moduleId = this.value;
                    if (isChecked) {
                        checkAncestors(this);
                        checkDescendants(moduleId, true);
                    } else {
                        checkDescendants(moduleId, false);
                    }
                });
            });
        })();
    </script>
    <script>
        (function(){
            const tree = document.getElementById('perm-tree');
            const btnExpand = document.getElementById('perm-expand');
            const btnCollapse = document.getElementById('perm-collapse');
            const search = document.getElementById('perm-search');

            function setAll(open) {
                tree.querySelectorAll('.perm-children').forEach(el => {
                    el.style.display = open ? '' : 'none';
                });
            }
            if (btnExpand) btnExpand.addEventListener('click', () => setAll(true));
            if (btnCollapse) btnCollapse.addEventListener('click', () => setAll(false));

            function matches(text, q) {
                return text.indexOf(q) !== -1;
            }
            function filterTree(q) {
                const items = Array.from(tree.querySelectorAll('.perm-item'));
                if (!q) {
                    items.forEach(i => i.style.display = '');
                    setAll(true);
                    return;
                }
                // Hide all first
                items.forEach(i => i.style.display = 'none');
                // Build index by id
                const map = {};
                items.forEach(i => map[i.dataset.id] = i);
                // Show matches and their ancestors
                items.forEach(i => {
                    const name = i.dataset.name || '';
                    if (matches(name, q)) {
                        let cur = i;
                        cur.style.display = '';
                        let parentId = cur.dataset.parentId;
                        while (parentId && map[parentId]) {
                            map[parentId].style.display = '';
                            const parentChildren = map[parentId].nextElementSibling;
                            if (parentChildren && parentChildren.classList.contains('perm-children')) {
                                parentChildren.style.display = '';
                            }
                            parentId = map[parentId].dataset.parentId;
                        }
                    }
                });
            }
            if (search) {
                search.addEventListener('input', function(){
                    const q = this.value.trim().toLowerCase();
                    filterTree(q);
                });
            }

            // Simple popover for content titles
            let pop;
            function closePop() {
                if (pop) { pop.remove(); pop = null; }
            }
            tree.addEventListener('click', function(e){
                const trigger = e.target.closest('.perm-pop-trigger');
                if (!trigger) return;
                e.preventDefault();
                e.stopPropagation();
                const titles = JSON.parse(trigger.dataset.titles || '[]');
                closePop();
                pop = document.createElement('div');
                pop.style.position = 'fixed';
                pop.style.maxWidth = '320px';
                pop.style.maxHeight = '240px';
                pop.style.overflow = 'auto';
                pop.style.background = '#fff';
                pop.style.border = '1px solid #e5e7eb';
                pop.style.borderRadius = '6px';
                pop.style.boxShadow = '0 10px 25px rgba(0,0,0,0.1)';
                pop.style.padding = '8px 10px';
                const list = document.createElement('ul');
                list.style.margin = '0';
                list.style.padding = '0';
                list.style.listStyle = 'none';
                titles.forEach(t => {
                    const li = document.createElement('li');
                    li.textContent = t;
                    li.style.padding = '6px 4px';
                    li.style.borderBottom = '1px solid #f3f4f6';
                    list.appendChild(li);
                });
                pop.appendChild(list);
                document.body.appendChild(pop);
                const rect = trigger.getBoundingClientRect();
                pop.style.left = Math.min(rect.left, window.innerWidth - pop.offsetWidth - 16) + 'px';
                pop.style.top = (rect.bottom + 8) + 'px';
                document.addEventListener('click', closePop, { once: true });
            });
        })();
    </script>
@endsection
