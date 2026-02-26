<x-layouts.app :title="'SPSOPKB'">
    <h1 class="text-lg font-bold text-gray-900 dark:text-white mb-6">SPSOPKB</h1>
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-5 shadow-sm text-center">
            <p class="text-2xl font-bold text-amber-600">{{ $totalCandidates }}</p><p class="text-xs text-gray-500">Kandidat</p>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-5 shadow-sm text-center">
            <p class="text-2xl font-bold text-blue-600">{{ $totalIssued }}</p><p class="text-xs text-gray-500">Surat Terbit</p>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-5 shadow-sm text-center">
            <p class="text-2xl font-bold text-indigo-600">{{ $ratio }}%</p><p class="text-xs text-gray-500">Rasio Surat/Total Tugas</p>
        </div>
    </div>
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm mb-6">
        <div class="px-5 py-4 border-b border-gray-200 dark:border-gray-700"><h3 class="text-sm font-semibold text-gray-800 dark:text-gray-200">Kandidat SPSOPKB</h3></div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 dark:bg-gray-700/50 text-xs text-gray-500 uppercase"><tr><th class="px-4 py-3 text-left">Nopol</th><th class="px-4 py-3 text-left">Pemilik</th><th class="px-4 py-3 text-center">Follow-up</th><th class="px-4 py-3 text-center">Umur</th><th class="px-4 py-3 text-center">Aksi</th></tr></thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    @forelse($candidates as $t)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30">
                        <td class="px-4 py-3 font-medium text-gray-900 dark:text-white">{{ $t->arrearsItem->plate_number ?? '-' }}</td>
                        <td class="px-4 py-3 text-gray-600">{{ $t->arrearsItem->owner_name ?? '-' }}</td>
                        <td class="px-4 py-3 text-center">{{ $t->followups_count }}</td>
                        <td class="px-4 py-3 text-center">{{ $t->age_days }}h</td>
                        <td class="px-4 py-3 text-center">
                            <form method="POST" action="{{ route('monitoring.spsopkb.promote', $t) }}" class="inline">@csrf
                                <button type="submit" class="text-xs px-3 py-1 rounded-lg bg-amber-100 text-amber-700 hover:bg-amber-200 transition font-medium">Promosikan</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="px-4 py-8 text-center text-gray-400">Tidak ada kandidat</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-4 py-3 border-t border-gray-100 dark:border-gray-700">{{ $candidates->links() }}</div>
    </div>
</x-layouts.app>
