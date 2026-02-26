<x-layouts.app :title="'Data Kendaraan'">
    <h1 class="text-lg font-bold text-gray-900 dark:text-white mb-6">Data Kendaraan (Jatuh Tempo)</h1>
    <form method="GET" class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-4 mb-6 shadow-sm flex flex-wrap gap-3">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nopol/nama WP..." class="rounded-lg border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-sm px-3 py-2 flex-1 min-w-[200px] dark:text-white">
        <select name="status_payment" class="rounded-lg border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-sm px-3 py-2 dark:text-white">
            <option value="">Semua</option>
            <option value="unpaid" {{ request('status_payment') === 'unpaid' ? 'selected' : '' }}>Belum Bayar</option>
            <option value="paid" {{ request('status_payment') === 'paid' ? 'selected' : '' }}>Sudah Bayar</option>
        </select>
        <input type="date" name="due_from" value="{{ request('due_from') }}" class="rounded-lg border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-sm px-3 py-2 dark:text-white">
        <input type="date" name="due_to" value="{{ request('due_to') }}" class="rounded-lg border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-sm px-3 py-2 dark:text-white">
        <button type="submit" class="rounded-lg bg-gray-800 dark:bg-gray-600 text-white px-4 py-2 text-sm font-medium hover:bg-gray-700 transition">Filter</button>
    </form>
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 dark:bg-gray-700/50 text-xs text-gray-500 uppercase"><tr><th class="px-4 py-3 text-left">Nopol</th><th class="px-4 py-3 text-left">Wajib Pajak</th><th class="px-4 py-3 text-center">Jatuh Tempo</th><th class="px-4 py-3 text-center">Status</th></tr></thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    @forelse($vehicles as $v)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30">
                        <td class="px-4 py-3 font-medium text-gray-900 dark:text-white">{{ $v->plate_number }}</td>
                        <td class="px-4 py-3 text-gray-600">{{ $v->taxpayer->name ?? '-' }}</td>
                        <td class="px-4 py-3 text-center {{ $v->due_date && $v->due_date->isPast() && $v->status_payment === 'unpaid' ? 'text-red-600 font-medium' : 'text-gray-500' }}">{{ $v->due_date?->format('d/m/Y') ?? '-' }}</td>
                        <td class="px-4 py-3 text-center">
                            <span class="px-2 py-0.5 text-xs rounded-full {{ $v->status_payment === 'paid' ? 'bg-emerald-100 text-emerald-700' : 'bg-red-100 text-red-700' }}">{{ $v->status_payment === 'paid' ? 'Lunas' : 'Belum' }}</span>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="px-4 py-12 text-center text-gray-400">Belum ada data</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-4 py-3 border-t border-gray-100 dark:border-gray-700">{{ $vehicles->links() }}</div>
    </div>
</x-layouts.app>
