<x-layouts.app :title="'Log Pesan WhatsApp'">
    <h1 class="text-lg font-bold text-gray-900 dark:text-white mb-6">Log Pesan WhatsApp</h1>
    <form method="GET" class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-4 mb-6 shadow-sm flex flex-wrap gap-3">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nomor HP..." class="rounded-lg border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-sm px-3 py-2 flex-1 min-w-[150px] dark:text-white">
        <select name="status" class="rounded-lg border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-sm px-3 py-2 dark:text-white">
            <option value="">Semua Status</option>
            <option value="queued" {{ request('status') === 'queued' ? 'selected' : '' }}>Antrian</option>
            <option value="sent" {{ request('status') === 'sent' ? 'selected' : '' }}>Terkirim</option>
            <option value="delivered" {{ request('status') === 'delivered' ? 'selected' : '' }}>Diterima</option>
            <option value="failed" {{ request('status') === 'failed' ? 'selected' : '' }}>Gagal</option>
        </select>
        <input type="date" name="date_from" value="{{ request('date_from') }}" class="rounded-lg border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-sm px-3 py-2 dark:text-white">
        <button type="submit" class="rounded-lg bg-gray-800 dark:bg-gray-600 text-white px-4 py-2 text-sm font-medium hover:bg-gray-700 transition">Filter</button>
    </form>
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 dark:bg-gray-700/50 text-xs text-gray-500 uppercase"><tr><th class="px-4 py-3 text-left">ID</th><th class="px-4 py-3 text-left">HP</th><th class="px-4 py-3 text-left">Pesan</th><th class="px-4 py-3 text-center">Status</th><th class="px-4 py-3 text-center">Retry</th><th class="px-4 py-3 text-left">Error</th><th class="px-4 py-3 text-center">Aksi</th></tr></thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    @forelse($logs as $log)
                    @php $lc = ['queued'=>'bg-gray-100 text-gray-700','sent'=>'bg-blue-100 text-blue-700','delivered'=>'bg-emerald-100 text-emerald-700','read'=>'bg-green-100 text-green-700','failed'=>'bg-red-100 text-red-700']; @endphp
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30">
                        <td class="px-4 py-3 text-gray-400 text-xs">#{{ $log->id }}</td>
                        <td class="px-4 py-3 text-gray-600">{{ $log->phone }}</td>
                        <td class="px-4 py-3 text-gray-500 text-xs max-w-[200px] truncate" title="{{ $log->message_body }}">{{ Str::limit($log->message_body, 50) }}</td>
                        <td class="px-4 py-3 text-center"><span class="px-2 py-0.5 text-xs rounded-full font-medium {{ $lc[$log->status] ?? '' }}">{{ ucfirst($log->status) }}</span></td>
                        <td class="px-4 py-3 text-center text-gray-400">{{ $log->retry_count }}</td>
                        <td class="px-4 py-3 text-xs text-red-500 max-w-[150px] truncate">{{ $log->error_message ?? '-' }}</td>
                        <td class="px-4 py-3 text-center">
                            @if($log->status === 'failed')
                            <form method="POST" action="{{ route('reminder.logs.retry', $log) }}" class="inline">@csrf
                                <button class="text-xs text-blue-600 hover:underline font-medium">Retry</button>
                            </form>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="7" class="px-4 py-12 text-center text-gray-400">Belum ada log pesan</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-4 py-3 border-t border-gray-100 dark:border-gray-700">{{ $logs->links() }}</div>
    </div>
</x-layouts.app>
