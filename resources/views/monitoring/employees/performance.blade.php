<x-layouts.app :title="'Kinerja Pegawai'">
    <h1 class="text-lg font-bold text-gray-900 dark:text-white mb-6">Kinerja Pegawai</h1>

    {{-- Search --}}
    <form method="GET" class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-4 mb-6 shadow-sm flex flex-wrap gap-3">
        @if(request('per_page'))
            <input type="hidden" name="per_page" value="{{ request('per_page') }}">
        @endif
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama pegawai/NIP..."
            class="rounded-lg border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-sm px-3 py-2 flex-1 min-w-[200px] dark:text-white focus:ring-blue-500">
        <button type="submit" class="rounded-lg bg-gray-800 dark:bg-gray-600 text-white px-4 py-2 text-sm font-medium hover:bg-gray-700 transition">Cari</button>
        @if(request('search'))
            <a href="{{ route('monitoring.kinerja.index') }}" class="rounded-lg border border-gray-300 dark:border-gray-600 text-gray-600 dark:text-gray-300 px-4 py-2 text-sm font-medium hover:bg-gray-50 dark:hover:bg-gray-700 transition">Reset</a>
        @endif
    </form>

    <x-data-table :paginator="$employees">
        <table class="w-full text-sm" data-sortable>
            <thead class="bg-gray-50 dark:bg-gray-700/50 text-xs text-gray-500 dark:text-gray-400 uppercase">
                <tr>
                    <th class="px-4 py-3 text-left" data-sort>Pegawai</th>
                    <th class="px-4 py-3 text-center" data-sort>Total Tugas</th>
                    <th class="px-4 py-3 text-center" data-sort>Aktif</th>
                    <th class="px-4 py-3 text-center" data-sort>Selesai</th>
                    <th class="px-4 py-3 text-center" data-sort>Telepon</th>
                    <th class="px-4 py-3 text-center" data-sort>Kunjungan</th>
                    <th class="px-4 py-3 text-center" data-sort>Avg Selesai</th>
                    <th class="px-4 py-3 text-center" data-sort>% Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                @forelse($employees as $emp)
                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30">
                    <td class="px-4 py-3">
                        <p class="font-medium text-gray-900 dark:text-white">{{ $emp->name }}</p>
                        <p class="text-xs text-gray-400">{{ $emp->jabatan ?? '-' }}</p>
                        @if($emp->nip)
                            <p class="text-xs text-gray-400">NIP: {{ $emp->nip }}</p>
                        @endif
                    </td>
                    <td class="px-4 py-3 text-center font-medium text-gray-900 dark:text-white">{{ $emp->total_tasks }}</td>
                    <td class="px-4 py-3 text-center"><span class="px-2 py-0.5 text-xs rounded-full {{ $emp->active_tasks > 10 ? 'bg-red-100 text-red-700' : 'bg-blue-100 text-blue-700' }}">{{ $emp->active_tasks }}</span></td>
                    <td class="px-4 py-3 text-center text-emerald-600 dark:text-emerald-400">{{ $emp->done_tasks }}</td>
                    <td class="px-4 py-3 text-center text-blue-600 dark:text-blue-400">{{ $emp->telepon_count }}</td>
                    <td class="px-4 py-3 text-center text-green-600 dark:text-green-400">{{ $emp->kunjungan_count }}</td>
                    <td class="px-4 py-3 text-center text-gray-500 dark:text-gray-400">{{ $emp->avg_completion_days }} hari</td>
                    <td class="px-4 py-3 text-center">
                        <div class="flex items-center justify-center space-x-2">
                            <div class="w-16 bg-gray-200 dark:bg-gray-600 rounded-full h-1.5"><div class="bg-blue-600 h-1.5 rounded-full" style="width: {{ $emp->status_percentage }}%"></div></div>
                            <span class="text-xs text-gray-500 dark:text-gray-400">{{ $emp->status_percentage }}%</span>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="8" class="px-4 py-12 text-center text-gray-400">Belum ada data pegawai</td></tr>
                @endforelse
            </tbody>
        </table>
    </x-data-table>
</x-layouts.app>
