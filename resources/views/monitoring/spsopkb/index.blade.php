<x-layouts.app :title="'SPSOPKB'">
    <h1 class="text-lg font-bold text-gray-900 dark:text-white mb-6">SPSOPKB</h1>

    {{-- Stats --}}
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

    {{-- Search --}}
    <form method="GET" class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-4 mb-6 shadow-sm flex flex-wrap gap-3">
        @if(request('per_page'))
            <input type="hidden" name="per_page" value="{{ request('per_page') }}">
        @endif
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nopol/nama pemilik..."
            class="rounded-lg border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-sm px-3 py-2 flex-1 min-w-[200px] dark:text-white focus:ring-blue-500">
        <button type="submit" class="rounded-lg bg-gray-800 dark:bg-gray-600 text-white px-4 py-2 text-sm font-medium hover:bg-gray-700 transition">Cari</button>
        @if(request('search'))
            <a href="{{ route('monitoring.spsopkb.index') }}" class="rounded-lg border border-gray-300 dark:border-gray-600 text-gray-600 dark:text-gray-300 px-4 py-2 text-sm font-medium hover:bg-gray-50 dark:hover:bg-gray-700 transition">Reset</a>
        @endif
    </form>

    {{-- Kandidat SPSOPKB --}}
    <div class="mb-6">
        <h3 class="text-sm font-semibold text-gray-800 dark:text-gray-200 mb-3">Kandidat SPSOPKB</h3>
        <x-data-table :paginator="$candidates">
            <table class="w-full text-sm" data-sortable>
                <thead class="bg-gray-50 dark:bg-gray-700/50 text-xs text-gray-500 uppercase">
                    <tr>
                        <th class="px-4 py-3 text-left" data-sort>Nopol</th>
                        <th class="px-4 py-3 text-left" data-sort>Pemilik</th>
                        <th class="px-4 py-3 text-center" data-sort>Follow-up</th>
                        <th class="px-4 py-3 text-center" data-sort>Umur</th>
                        <th class="px-4 py-3 text-center">Aksi</th>
                    </tr>
                </thead>
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
        </x-data-table>
    </div>

    {{-- Surat Terbit --}}
    <div>
        <h3 class="text-sm font-semibold text-gray-800 dark:text-gray-200 mb-3">Surat SPSOPKB Terbit</h3>
        <x-data-table :paginator="$letters">
            <table class="w-full text-sm" data-sortable>
                <thead class="bg-gray-50 dark:bg-gray-700/50 text-xs text-gray-500 uppercase">
                    <tr>
                        <th class="px-4 py-3 text-left" data-sort>Nopol</th>
                        <th class="px-4 py-3 text-left" data-sort>Pemilik</th>
                        <th class="px-4 py-3 text-center" data-sort>Tanggal Terbit</th>
                        <th class="px-4 py-3 text-center" data-sort>Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    @forelse($letters as $letter)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30">
                        <td class="px-4 py-3 font-medium text-gray-900 dark:text-white">{{ $letter->task->arrearsItem->plate_number ?? '-' }}</td>
                        <td class="px-4 py-3 text-gray-600">{{ $letter->task->arrearsItem->owner_name ?? '-' }}</td>
                        <td class="px-4 py-3 text-center text-gray-500">{{ $letter->issued_date?->format('d/m/Y') ?? '-' }}</td>
                        <td class="px-4 py-3 text-center">
                            <span class="px-2 py-0.5 text-xs rounded-full font-medium {{ $letter->status === 'terbit' ? 'bg-blue-100 text-blue-700' : 'bg-gray-100 text-gray-700' }}">{{ ucfirst($letter->status) }}</span>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="px-4 py-8 text-center text-gray-400">Belum ada surat SPSOPKB</td></tr>
                    @endforelse
                </tbody>
            </table>
        </x-data-table>
    </div>
</x-layouts.app>
