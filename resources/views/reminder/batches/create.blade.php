<x-layouts.app :title="'Buat Batch Reminder'">
    <div class="max-w-2xl mx-auto">
        <a href="{{ route('reminder.batches.index') }}" class="inline-flex items-center text-sm text-gray-500 hover:text-gray-700 mb-4">
            <svg class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"/></svg> Kembali
        </a>
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6 shadow-sm">
            <h1 class="text-lg font-bold text-gray-900 dark:text-white mb-6">Buat Batch Reminder</h1>
            <form method="POST" action="{{ route('reminder.batches.store') }}" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Aturan Reminder</label>
                    <select name="reminder_rule_id" required class="w-full rounded-lg border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-sm dark:text-white">
                        @foreach($rules as $rule)
                            <option value="{{ $rule->id }}">{{ $rule->name }} (H-{{ $rule->days_before_due }})</option>
                        @endforeach
                    </select>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Jatuh Tempo Dari</label>
                        <input type="date" name="due_date_from" required class="w-full rounded-lg border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-sm dark:text-white">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Jatuh Tempo Sampai</label>
                        <input type="date" name="due_date_to" required class="w-full rounded-lg border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-sm dark:text-white">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Deskripsi Filter (opsional)</label>
                    <textarea name="filter_description" rows="2" class="w-full rounded-lg border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-sm dark:text-white" placeholder="Catatan tentang batch ini..."></textarea>
                </div>
                <button type="submit" class="w-full py-2.5 rounded-lg bg-gradient-to-r from-green-600 to-emerald-600 text-white font-medium text-sm hover:from-green-500 hover:to-emerald-500 transition shadow-sm">Generate Batch</button>
            </form>
        </div>
    </div>
</x-layouts.app>
