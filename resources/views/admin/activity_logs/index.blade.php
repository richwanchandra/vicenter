@extends('layouts.app')

@section('page_title', 'Audit Logs')

@section('content')
    <div class="bg-white p-6 rounded-lg shadow border border-gray-200 mb-6">
        <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">User</label>
                <select name="user_id" class="w-full border border-gray-300 rounded px-3 py-2">
                    <option value="">All</option>
                    @foreach($users as $u)
                        <option value="{{ $u->id }}" {{ request('user_id') == $u->id ? 'selected' : '' }}>{{ $u->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Module</label>
                <select name="module_id" class="w-full border border-gray-300 rounded px-3 py-2">
                    <option value="">All</option>
                    @foreach($modules as $m)
                        <option value="{{ $m->id }}" {{ request('module_id') == $m->id ? 'selected' : '' }}>{{ $m->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Action</label>
                <input type="text" name="action" value="{{ request('action') }}" class="w-full border border-gray-300 rounded px-3 py-2" placeholder="e.g. create_module">
            </div>
            <div class="flex items-end">
                <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Filter</button>
            </div>
        </form>
    </div>

    <div class="bg-white p-6 rounded-lg shadow border border-gray-200">
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead>
                    <tr class="text-left border-b">
                        <th class="px-4 py-2">Time</th>
                        <th class="px-4 py-2">User</th>
                        <th class="px-4 py-2">Action</th>
                        <th class="px-4 py-2">Module</th>
                        <th class="px-4 py-2">Description</th>
                        <th class="px-4 py-2">IP</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($logs as $log)
                        <tr class="border-b">
                            <td class="px-4 py-2 whitespace-nowrap">{{ $log->created_at?->format('Y-m-d H:i:s') }}</td>
                            <td class="px-4 py-2">{{ $log->user?->name ?? '-' }}</td>
                            <td class="px-4 py-2 font-mono">{{ $log->action }}</td>
                            <td class="px-4 py-2">{{ $log->module?->name ?? '-' }}</td>
                            <td class="px-4 py-2">{{ $log->description ?? '-' }}</td>
                            <td class="px-4 py-2">{{ $log->ip_address ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td class="px-4 py-6 text-center text-gray-500" colspan="6">No logs found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            {{ $logs->links() }}
        </div>
    </div>
@endsection
