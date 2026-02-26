<x-layouts.app :title="'Kinerja Pegawai'">
    <h1 class="text-lg font-bold text-gray-900 dark:text-white mb-6">Kinerja Pegawai</h1>
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 dark:bg-gray-700/50 text-xs text-gray-500 dark:text-gray-400 uppercase">
                    <tr><th class="px-4 py-3 text-left">Pegawai</th><th class="px-4 py-3 text-center">Total Tugas</th><th class="px-4 py-3 text-center">Aktif</th><th class="px-4 py-3 text-center">Selesai</th><th class="px-4 py-3 text-center">Telepon</th><th class="px-4 py-3 text-center">Kunjungan</th><th class="px-4 py-3 text-center">Avg Selesai</th><th class="px-4 py-3 text-center">% Status</th></tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    @forelse($employees as $emp)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30">
                        <td class="px-4 py-3">
                            <p class="font-medium text-gray-900 dark:text-white">{{ $emp->name }}</p>
                            <p class="text-xs text-gray-400">{{ $emp->jabatan ?? '-' }}</p>
                        </td>
                        <td class="px-4 py-3 text-center font-medium">{{ $emp->total_tasks }}</td>
                        <td class="px-4 py-3 text-center"><span class="px-2 py-0.5 text-xs rounded-full {{ $emp->active_tasks > 10 ? 'bg-red-100 text-red-700' : 'bg-blue-100 text-blue-700' }}">{{ $emp->active_tasks }}</span></td>
                        <td class="px-4 py-3 text-center text-emerald-600">{{ $emp->done_tasks }}</td>
                        <td class="px-4 py-3 text-center text-blue-600">{{ $emp->telepon_count }}</td>
                        <td class="px-4 py-3 text-center text-green-600">{{ $emp->kunjungan_count }}</td>
                        <td class="px-4 py-3 text-center text-gray-500">{{ $emp->avg_completion_days }} hari</td>
                        <td class="px-4 py-3 text-center">
                            <div class="flex items-center justify-center space-x-2">
                                <div class="w-16 bg-gray-200 dark:bg-gray-600 rounded-full h-1.5"><div class="bg-blue-600 h-1.5 rounded-full" style="width: {{ $emp->status_percentage }}%"></div></div>
                                <span class="text-xs text-gray-500">{{ $emp->status_percentage }}%</span>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="8" class="px-4 py-12 text-center text-gray-400">Belum ada data pegawai</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-layouts.app>
