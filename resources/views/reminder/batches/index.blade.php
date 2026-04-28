<x-layouts.app :title="'Batch Reminder'">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-lg font-bold text-gray-900 dark:text-white">Batch Reminder</h1>
        <a href="{{ route('reminder.batches.create') }}" class="inline-flex items-center px-4 py-2 rounded-lg bg-gradient-to-r from-green-600 to-emerald-600 text-white text-sm font-medium hover:from-green-500 hover:to-emerald-500 transition shadow-sm">
            <svg class="w-4 h-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
            Buat Batch
        </a>
    </div>

    <x-data-table :paginator="$batches">
        <table class="w-full text-sm" data-sortable>
            <thead class="bg-gray-50 dark:bg-gray-700/50 text-xs text-gray-500 dark:text-gray-400 uppercase">
                <tr>
                    <th class="px-4 py-3 text-left" data-sort>ID</th>
                    <th class="px-4 py-3 text-left" data-sort>Dibuat</th>
                    <th class="px-4 py-3 text-center" data-sort>Total</th>
                    <th class="px-4 py-3 text-center" data-sort>Terkirim</th>
                    <th class="px-4 py-3 text-center" data-sort>Gagal</th>
                    <th class="px-4 py-3 text-center" data-sort>Status</th>
                    <th class="px-4 py-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                @forelse($batches as $b)
                @php
                    $statusColors = ['draft'=>'bg-gray-100 text-gray-700','pending_approval'=>'bg-amber-100 text-amber-700','approved'=>'bg-blue-100 text-blue-700','scheduled'=>'bg-indigo-100 text-indigo-700','processing'=>'bg-cyan-100 text-cyan-700','done'=>'bg-emerald-100 text-emerald-700','rejected'=>'bg-red-100 text-red-700'];
                @endphp
                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30">
                    <td class="px-4 py-3 text-gray-500 dark:text-gray-400">#{{ $b->id }}</td>
                    <td class="px-4 py-3 text-gray-600 dark:text-gray-300">{{ $b->creator->name ?? '-' }} <span class="text-xs text-gray-400 dark:text-gray-500">{{ $b->created_at->format('d/m H:i') }}</span></td>
                    <td class="px-4 py-3 text-center font-medium text-gray-900 dark:text-white">{{ $b->total_items }}</td>
                    <td class="px-4 py-3 text-center text-emerald-600">{{ $b->sent_count }}</td>
                    <td class="px-4 py-3 text-center text-red-600">{{ $b->failed_count }}</td>
                    <td class="px-4 py-3 text-center"><span class="px-2 py-0.5 text-xs rounded-full font-medium {{ $statusColors[$b->status] ?? '' }}">{{ str_replace('_', ' ', ucfirst($b->status)) }}</span></td>
                    <td class="px-4 py-3 text-center"><a href="{{ route('reminder.batches.show', $b) }}" class="text-xs text-blue-600 hover:underline">Detail</a></td>
                </tr>
                @empty
                <tr><td colspan="7" class="px-4 py-12 text-center text-gray-400">Belum ada batch</td></tr>
                @endforelse
            </tbody>
        </table>
    </x-data-table>
</x-layouts.app>
