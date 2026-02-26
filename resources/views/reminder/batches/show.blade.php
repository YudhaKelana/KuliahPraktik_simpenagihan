<x-layouts.app :title="'Detail Batch #' . $batch->id">
    <div class="max-w-5xl mx-auto">
        <a href="{{ route('reminder.batches.index') }}" class="inline-flex items-center text-sm text-gray-500 hover:text-gray-700 mb-4">
            <svg class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"/></svg> Kembali
        </a>

        {{-- Batch Info --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6 mb-6 shadow-sm">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-4">
                <div>
                    <h1 class="text-xl font-bold text-gray-900 dark:text-white">Batch #{{ $batch->id }}</h1>
                    <p class="text-sm text-gray-500 mt-0.5">{{ $batch->filter_description ?? '-' }}</p>
                </div>
                @php $sc = ['draft'=>'bg-gray-100 text-gray-700','pending_approval'=>'bg-amber-100 text-amber-700','approved'=>'bg-blue-100 text-blue-700','scheduled'=>'bg-indigo-100 text-indigo-700','processing'=>'bg-cyan-100 text-cyan-700','done'=>'bg-emerald-100 text-emerald-700','rejected'=>'bg-red-100 text-red-700']; @endphp
                <span class="px-3 py-1 text-sm rounded-lg font-medium {{ $sc[$batch->status] ?? '' }}">{{ str_replace('_',' ',ucfirst($batch->status)) }}</span>
            </div>
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 text-sm mb-4">
                <div><span class="text-gray-500">Total Item</span><p class="font-medium text-gray-900 dark:text-white">{{ $batch->total_items }}</p></div>
                <div><span class="text-gray-500">Terkirim</span><p class="font-medium text-emerald-600">{{ $batch->sent_count }}</p></div>
                <div><span class="text-gray-500">Gagal</span><p class="font-medium text-red-600">{{ $batch->failed_count }}</p></div>
                <div><span class="text-gray-500">Dilewati</span><p class="font-medium text-gray-500">{{ $batch->skipped_count }}</p></div>
            </div>
            {{-- Actions --}}
            <div class="flex flex-wrap gap-2">
                @if(in_array($batch->status, ['draft', 'pending_approval']) && auth()->user()->hasRole(['admin', 'supervisor']))
                    <form method="POST" action="{{ route('reminder.batches.approve', $batch) }}" class="inline">@csrf
                        <button class="px-4 py-2 rounded-lg bg-emerald-600 text-white text-sm font-medium hover:bg-emerald-700 transition">✓ Setujui</button>
                    </form>
                    <form method="POST" action="{{ route('reminder.batches.reject', $batch) }}" class="inline flex items-center gap-2" onsubmit="return this.reject_reason.value ? true : (alert('Isi alasan penolakan'),false)">@csrf
                        <input type="text" name="reject_reason" placeholder="Alasan..." class="rounded-lg border-gray-300 text-sm px-3 py-2 w-40">
                        <button class="px-4 py-2 rounded-lg bg-red-600 text-white text-sm font-medium hover:bg-red-700 transition">✗ Tolak</button>
                    </form>
                @endif
                @if($batch->status === 'approved')
                    <form method="POST" action="{{ route('reminder.batches.schedule', $batch) }}" class="inline">@csrf
                        <button class="px-4 py-2 rounded-lg bg-blue-600 text-white text-sm font-medium hover:bg-blue-700 transition">🚀 Jadwalkan Kirim</button>
                    </form>
                @endif
            </div>
        </div>

        {{-- Items --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 dark:bg-gray-700/50 text-xs text-gray-500 uppercase"><tr><th class="px-4 py-3 text-left">Nopol</th><th class="px-4 py-3 text-left">WP</th><th class="px-4 py-3 text-center">Rule</th><th class="px-4 py-3 text-center">Jadwal Kirim</th><th class="px-4 py-3 text-center">Status</th><th class="px-4 py-3 text-left">Alasan Skip</th></tr></thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                        @forelse($items as $item)
                        @php $ic = ['pending'=>'bg-gray-100 text-gray-700','queued'=>'bg-blue-100 text-blue-700','sent'=>'bg-emerald-100 text-emerald-700','delivered'=>'bg-green-100 text-green-700','failed'=>'bg-red-100 text-red-700','skipped'=>'bg-amber-100 text-amber-700']; @endphp
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30">
                            <td class="px-4 py-3 font-medium text-gray-900 dark:text-white">{{ $item->vehicle->plate_number ?? '-' }}</td>
                            <td class="px-4 py-3 text-gray-600">{{ $item->vehicle->taxpayer->name ?? '-' }}</td>
                            <td class="px-4 py-3 text-center text-gray-500 text-xs">{{ $item->rule->name ?? '-' }}</td>
                            <td class="px-4 py-3 text-center text-gray-500 text-xs">{{ $item->planned_send_at?->format('d/m H:i') ?? '-' }}</td>
                            <td class="px-4 py-3 text-center"><span class="px-2 py-0.5 text-xs rounded-full font-medium {{ $ic[$item->status] ?? '' }}">{{ ucfirst($item->status) }}</span></td>
                            <td class="px-4 py-3 text-gray-400 text-xs">{{ $item->skip_reason ?? '-' }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="6" class="px-4 py-8 text-center text-gray-400">Tidak ada item</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="px-4 py-3 border-t border-gray-100 dark:border-gray-700">{{ $items->links() }}</div>
        </div>
    </div>
</x-layouts.app>
