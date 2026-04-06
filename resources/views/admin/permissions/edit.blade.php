@extends('layouts.app')

@section('page_title', 'Manage Permissions for ' . $user->name)

@section('content')
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Permissions Tree -->
        <div class="lg:col-span-2">
            <div class="bg-white p-6 rounded-lg shadow border border-gray-200 mb-6">
                <h3 class="text-lg font-semibold mb-4 text-gray-800">Module Permissions</h3>

                <form method="POST" action="{{ route('admin.permissions.update', $user) }}" id="permissionForm">
                    @csrf @method('PUT')

                    <div class="mb-4 flex gap-2">
                        <button type="button" id="selectAll"
                            class="text-sm bg-blue-100 text-blue-700 px-3 py-1 rounded hover:bg-blue-200">
                            Select All
                        </button>
                        <button type="button" id="deselectAll"
                            class="text-sm bg-gray-100 text-gray-700 px-3 py-1 rounded hover:bg-gray-200">
                            Deselect All
                        </button>
                    </div>

                    <div class="space-y-2 max-h-96 overflow-y-auto">
                        @foreach($modules as $module)
                            @include('admin.permissions.module-tree', ['module' => $module, 'depth' => 0, 'selected' => $selected])
                        @endforeach
                    </div>

                    <div class="flex gap-4 pt-6 border-t mt-4">
                        <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 transition">
                            Save Permissions
                        </button>
                        <a href="{{ route('admin.permissions.index') }}"
                            class="bg-gray-300 text-gray-700 px-6 py-2 rounded hover:bg-gray-400 transition">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Sidebar -->
        <aside>
            <!-- User Info -->
            <div class="bg-white p-6 rounded-lg shadow border border-gray-200 mb-6">
                <h4 class="text-lg font-semibold mb-4 text-gray-800">User Info</h4>
                <div class="space-y-3 text-sm">
                    <div>
                        <p class="text-gray-600">Name</p>
                        <p class="font-semibold text-gray-800">{{ $user->name }}</p>
                    </div>
                    <div>
                        <p class="text-gray-600">Email</p>
                        <p class="font-semibold text-gray-800">{{ $user->email }}</p>
                    </div>
                    <div>
                        <p class="text-gray-600">Role</p>
                        <p class="font-semibold text-gray-800">{{ ucfirst(str_replace('_', ' ', $user->role)) }}</p>
                    </div>
                    <div>
                        <p class="text-gray-600">Joined</p>
                        <p class="font-semibold text-gray-800">{{ $user->created_at->format('d M Y') }}</p>
                    </div>
                </div>
            </div>

            <!-- Clone Permissions FROM others -->
            <div class="bg-white p-6 rounded-lg shadow border border-gray-200 mb-6">
                <h4 class="text-lg font-semibold mb-4 text-gray-800">Clone From User</h4>
                <p class="text-sm text-gray-600 mb-4">Copy permissions from another user to this user.</p>

                <form method="POST" action="{{ route('admin.permissions.clone', $user) }}">
                    @csrf
                    <select name="from_user_id" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm mb-3">
                        <option value="">Select User</option>
                        @foreach(\App\Models\User::where('id', '!=', $user->id)->get() as $otherUser)
                            <option value="{{ $otherUser->id }}">{{ $otherUser->name }}</option>
                        @endforeach
                    </select>
                    <button type="submit"
                        class="w-full bg-green-600 text-white px-3 py-2 rounded hover:bg-green-700 transition text-sm"
                        onclick="return confirm('Clone permissions from selected user?')">
                        Clone Permissions
                    </button>
                </form>
            </div>

            <!-- Apply THIS user's permissions TO others -->
            <div class="bg-white p-6 rounded-lg shadow border border-gray-200">
                <h4 class="text-lg font-semibold mb-4 text-gray-800">Apply To Others</h4>
                <p class="text-sm text-gray-600 mb-4">Copy this user's permissions to multiple other users.</p>

                <form method="POST" action="{{ route('admin.permissions.bulkClone', $user) }}">
                    @csrf
                    <select name="to_user_ids[]" multiple required
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm mb-2"
                        style="min-height: 120px;">
                        @foreach(\App\Models\User::where('id', '!=', $user->id)->where('role', 'user')->get() as $otherUser)
                            <option value="{{ $otherUser->id }}">{{ $otherUser->name }}</option>
                        @endforeach
                    </select>
                    <p class="text-xs text-gray-500 mb-3">Hold Ctrl/Cmd to select multiple users.</p>
                    <button type="submit"
                        class="w-full bg-blue-600 text-white px-3 py-2 rounded hover:bg-blue-700 transition text-sm"
                        onclick="return confirm('Copy permissions to selected users?')">
                        Copy Permissions to Selected
                    </button>
                </form>
            </div>
        </aside>
    </div>

    <script>
        const checkboxes = document.querySelectorAll('input[name="modules[]"]');

        document.getElementById('selectAll').addEventListener('click', function () {
            checkboxes.forEach(el => el.checked = true);
        });

        document.getElementById('deselectAll').addEventListener('click', function () {
            checkboxes.forEach(el => el.checked = false);
        });

        // Handle parent-child relationships
        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function () {
                const isChecked = this.checked;
                const moduleId = this.value;

                if (isChecked) {
                    // 1. When checking a child, check all its ancestors
                    checkAncestors(this);
                    // 2. When checking a parent, check all its descendants
                    checkDescendants(moduleId, true);
                } else {
                    // 3. When unchecking a parent, uncheck all its descendants
                    checkDescendants(moduleId, false);
                }
            });
        });

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
    </script>
@endsection