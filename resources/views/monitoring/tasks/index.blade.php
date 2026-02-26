<x-layouts.app :title="'Daftar Tugas & Follow-up'">
    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6">
        <h1 class="text-lg font-bold text-gray-900 dark:text-white">Tugas & Follow-up</h1>
        <a href="{{ route('monitoring.tasks.create') }}" class="mt-2 sm:mt-0 inline-flex items-center px-4 py-2 rounded-lg bg-gradient-to-r from-blue-600 to-indigo-600 text-white text-sm font-medium hover:from-blue-500 hover:to-indigo-500 transition shadow-sm">
            <svg class="w-4 h-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
            Tugas Baru
        </a>
    </div>

    {{-- Filters --}}
    <form method="GET" class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-4 mb-6 shadow-sm">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nopol/pemilik..." class="rounded-lg border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-sm px-3 py-2 focus:ring-blue-500 dark:text-white">
            <select name="status" class="rounded-lg border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-sm px-3 py-2 dark:text-white">
                <option value="">Semua Status</option>
                <option value="new" {{ request('status') === 'new' ? 'selected' : '' }}>Baru</option>
                <option value="in_progress" {{ request('status') === 'in_progress' ? 'selected' : '' }}>Dalam Proses</option>
                <option value="done" {{ request('status') === 'done' ? 'selected' : '' }}>Selesai</option>
            </select>
            <select name="employee_id" class="rounded-lg border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-sm px-3 py-2 dark:text-white">
                <option value="">Semua PIC</option>
                @foreach($employees as $emp)
                    <option value="{{ $emp->id }}" {{ request('employee_id') == $emp->id ? 'selected' : '' }}>{{ $emp->name }}</option>
                @endforeach
            </select>
            <select name="flag" class="rounded-lg border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-sm px-3 py-2 dark:text-white">
                <option value="">Semua</option>
                <option value="overdue" {{ request('flag') === 'overdue' ? 'selected' : '' }}>🔴 Overdue</option>
                <option value="missing_status" {{ request('flag') === 'missing_status' ? 'selected' : '' }}>🟡 Belum Input Status</option>
            </select>
            <button type="submit" class="rounded-lg bg-gray-800 dark:bg-gray-600 text-white px-4 py-2 text-sm font-medium hover:bg-gray-700 transition">Filter</button>
        </div>
    </form>

    {{-- Table --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 dark:bg-gray-700/50 text-xs text-gray-500 dark:text-gray-400 uppercase">
                    <tr>
                        <th class="px-4 py-3 text-left">ID</th>
                        <th class="px-4 py-3 text-left">Nopol</th>
                        <th class="px-4 py-3 text-left">Pemilik</th>
                        <th class="px-4 py-3 text-left">HP</th>
                        <th class="px-4 py-3 text-left">PIC</th>
                        <th class="px-4 py-3 text-center">Status</th>
                        <th class="px-4 py-3 text-center">Follow-up</th>
                        <th class="px-4 py-3 text-center">Umur</th>
                        <th class="px-4 py-3 text-center">Flags</th>
                        <th class="px-4 py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    @forelse($tasks as $task)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30 transition">
                        <td class="px-4 py-3 text-gray-500">#{{ $task->id }}</td>
                        <td class="px-4 py-3 font-medium text-gray-900 dark:text-white">{{ $task->arrearsItem->plate_number ?? '-' }}</td>
                        <td class="px-4 py-3 text-gray-600 dark:text-gray-300">{{ $task->arrearsItem->owner_name ?? '-' }}</td>
                        <td class="px-4 py-3 text-gray-500">{{ $task->arrearsItem->masked_phone ?? '-' }}</td>
                        <td class="px-4 py-3 text-gray-600 dark:text-gray-300">{{ $task->employee->name ?? '-' }}</td>
                        <td class="px-4 py-3 text-center">
                            @php $statusColors = ['new' => 'bg-gray-100 text-gray-700', 'in_progress' => 'bg-blue-100 text-blue-700', 'done' => 'bg-emerald-100 text-emerald-700']; @endphp
                            <span class="px-2 py-0.5 text-xs rounded-full font-medium {{ $statusColors[$task->status] ?? 'bg-gray-100' }}">
                                {{ $task->status === 'new' ? 'Baru' : ($task->status === 'in_progress' ? 'Proses' : 'Selesai') }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-center text-gray-500">{{ $task->followups_count }}</td>
                        <td class="px-4 py-3 text-center text-gray-500">{{ $task->age_days }}h</td>
                        <td class="px-4 py-3 text-center space-x-1">
                            @if($task->overdue_level === 'critical')
                                <span class="inline-block w-2 h-2 rounded-full bg-red-500" title="Overdue Kritis"></span>
                            @elseif($task->overdue_level === 'warning')
                                <span class="inline-block w-2 h-2 rounded-full bg-amber-500" title="Overdue Peringatan"></span>
                            @endif
                            @if($task->is_missing_status)
                                <span class="inline-block w-2 h-2 rounded-full bg-yellow-400" title="Belum input status"></span>
                            @endif
                            @if($task->arrearsItem?->is_data_incomplete)
                                <span class="inline-block w-2 h-2 rounded-full bg-purple-500" title="Data tidak lengkap"></span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-center">
                            <a href="{{ route('monitoring.tasks.show', $task) }}" class="text-blue-600 hover:text-blue-800 text-xs font-medium">Detail</a>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="10" class="px-4 py-12 text-center text-gray-400">Belum ada data tugas. <a href="{{ route('monitoring.tasks.create') }}" class="text-blue-600 hover:underline">Buat tugas baru</a></td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-4 py-3 border-t border-gray-100 dark:border-gray-700">
            {{ $tasks->links() }}
        </div>
    </div>
</x-layouts.app>
