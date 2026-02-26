<x-layouts.app :title="'Kontak Wajib Pajak'">
    <h1 class="text-lg font-bold text-gray-900 dark:text-white mb-6">Kontak Wajib Pajak</h1>
    <form method="GET" class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-4 mb-6 shadow-sm flex flex-wrap gap-3">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama/NIK/HP..." class="rounded-lg border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-sm px-3 py-2 flex-1 min-w-[200px] dark:text-white">
        <select name="opt_out" class="rounded-lg border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-sm px-3 py-2 dark:text-white">
            <option value="">Semua</option>
            <option value="yes" {{ request('opt_out') === 'yes' ? 'selected' : '' }}>Opt-Out</option>
            <option value="no" {{ request('opt_out') === 'no' ? 'selected' : '' }}>Aktif</option>
        </select>
        <button type="submit" class="rounded-lg bg-gray-800 dark:bg-gray-600 text-white px-4 py-2 text-sm font-medium hover:bg-gray-700 transition">Filter</button>
    </form>
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 dark:bg-gray-700/50 text-xs text-gray-500 uppercase"><tr><th class="px-4 py-3 text-left">Nama</th><th class="px-4 py-3 text-left">NIK</th><th class="px-4 py-3 text-left">HP</th><th class="px-4 py-3 text-center">Kendaraan</th><th class="px-4 py-3 text-center">Status</th><th class="px-4 py-3 text-center">Aksi</th></tr></thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    @forelse($taxpayers as $tp)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30">
                        <td class="px-4 py-3 font-medium text-gray-900 dark:text-white">{{ $tp->name }}</td>
                        <td class="px-4 py-3 text-gray-500">{{ $tp->nik ?? '-' }}</td>
                        <td class="px-4 py-3 text-gray-500">{{ $tp->masked_phone }}</td>
                        <td class="px-4 py-3 text-center text-gray-600">{{ $tp->vehicles_count }}</td>
                        <td class="px-4 py-3 text-center">
                            @if($tp->opt_out)
                                <span class="px-2 py-0.5 text-xs rounded-full bg-red-100 text-red-700">Opt-Out</span>
                            @else
                                <span class="px-2 py-0.5 text-xs rounded-full bg-emerald-100 text-emerald-700">Aktif</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-center space-x-2">
                            <form method="POST" action="{{ route('reminder.taxpayers.toggle-optout', $tp) }}" class="inline">@csrf
                                <button type="submit" class="text-xs text-blue-600 hover:underline">{{ $tp->opt_out ? 'Aktifkan' : 'Opt-Out' }}</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="px-4 py-12 text-center text-gray-400">Belum ada data</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-4 py-3 border-t border-gray-100 dark:border-gray-700">{{ $taxpayers->links() }}</div>
    </div>
</x-layouts.app>
