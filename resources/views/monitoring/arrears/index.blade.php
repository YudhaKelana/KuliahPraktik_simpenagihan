<x-layouts.app :title="'Tunggakan'">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-lg font-bold text-gray-900 dark:text-white">Data Tunggakan</h1>
    </div>
    <form method="GET" class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-4 mb-6 shadow-sm flex flex-wrap gap-3">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nopol/pemilik..." class="rounded-lg border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-sm px-3 py-2 flex-1 min-w-[200px] dark:text-white">
        <select name="flag" class="rounded-lg border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-sm px-3 py-2 dark:text-white">
            <option value="">Semua Flag</option>
            <option value="phone_invalid" {{ request('flag') === 'phone_invalid' ? 'selected' : '' }}>HP Tidak Valid</option>
            <option value="address_suspect" {{ request('flag') === 'address_suspect' ? 'selected' : '' }}>Alamat Rawan</option>
            <option value="incomplete" {{ request('flag') === 'incomplete' ? 'selected' : '' }}>Data Tidak Lengkap</option>
        </select>
        <button type="submit" class="rounded-lg bg-gray-800 dark:bg-gray-600 text-white px-4 py-2 text-sm font-medium hover:bg-gray-700 transition">Filter</button>
    </form>
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 dark:bg-gray-700/50 text-xs text-gray-500 dark:text-gray-400 uppercase">
                    <tr><th class="px-4 py-3 text-left">Nopol</th><th class="px-4 py-3 text-left">Pemilik</th><th class="px-4 py-3 text-left">HP</th><th class="px-4 py-3 text-right">Tunggakan</th><th class="px-4 py-3 text-center">Tahun</th><th class="px-4 py-3 text-center">Flags</th><th class="px-4 py-3 text-center">Tgl Kalkulasi</th></tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    @forelse($arrears as $item)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30">
                        <td class="px-4 py-3 font-medium text-gray-900 dark:text-white">{{ $item->plate_number }}</td>
                        <td class="px-4 py-3 text-gray-600 dark:text-gray-300">{{ $item->owner_name ?? '-' }}</td>
                        <td class="px-4 py-3 text-gray-500">{{ $item->masked_phone }}</td>
                        <td class="px-4 py-3 text-right text-gray-900 dark:text-white font-medium">Rp {{ number_format($item->arrears_amount, 0, ',', '.') }}</td>
                        <td class="px-4 py-3 text-center text-gray-500">{{ $item->arrears_years }}</td>
                        <td class="px-4 py-3 text-center space-x-1">
                            @if($item->flag_phone_invalid)<span class="inline-block w-2 h-2 rounded-full bg-red-500" title="HP tidak valid"></span>@endif
                            @if($item->flag_address_suspect)<span class="inline-block w-2 h-2 rounded-full bg-amber-500" title="Alamat rawan"></span>@endif
                        </td>
                        <td class="px-4 py-3 text-center text-gray-400 text-xs">{{ $item->calculation_date?->format('d/m/Y') ?? '-' }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="7" class="px-4 py-12 text-center text-gray-400">Belum ada data tunggakan</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-4 py-3 border-t border-gray-100 dark:border-gray-700">{{ $arrears->links() }}</div>
    </div>
</x-layouts.app>
