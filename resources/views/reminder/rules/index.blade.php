<x-layouts.app :title="'Aturan Reminder'">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-lg font-bold text-gray-900 dark:text-white">Aturan Reminder</h1>
        <a href="{{ route('reminder.rules.create') }}" class="inline-flex items-center px-4 py-2 rounded-lg bg-gradient-to-r from-blue-600 to-indigo-600 text-white text-sm font-medium hover:from-blue-500 hover:to-indigo-500 transition shadow-sm">
            <svg class="w-4 h-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
            Tambah Aturan
        </a>
    </div>
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 dark:bg-gray-700/50 text-xs text-gray-500 uppercase"><tr><th class="px-4 py-3 text-left">Nama</th><th class="px-4 py-3 text-center">Hari</th><th class="px-4 py-3 text-center">Window</th><th class="px-4 py-3 text-center">Status</th><th class="px-4 py-3 text-center">Aksi</th></tr></thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    @forelse($rules as $rule)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30">
                        <td class="px-4 py-3"><p class="font-medium text-gray-900 dark:text-white">{{ $rule->name }}</p><p class="text-xs text-gray-400">{{ $rule->template_code }}</p></td>
                        <td class="px-4 py-3 text-center font-bold text-blue-600">H-{{ $rule->days_before_due }}</td>
                        <td class="px-4 py-3 text-center text-gray-500 text-xs">{{ $rule->send_window_start }} — {{ $rule->send_window_end }}</td>
                        <td class="px-4 py-3 text-center"><span class="px-2 py-0.5 text-xs rounded-full {{ $rule->is_active ? 'bg-emerald-100 text-emerald-700' : 'bg-gray-100 text-gray-500' }}">{{ $rule->is_active ? 'Aktif' : 'Nonaktif' }}</span></td>
                        <td class="px-4 py-3 text-center"><a href="{{ route('reminder.rules.edit', $rule) }}" class="text-xs text-blue-600 hover:underline">Edit</a></td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="px-4 py-8 text-center text-gray-400">Belum ada aturan</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-layouts.app>
