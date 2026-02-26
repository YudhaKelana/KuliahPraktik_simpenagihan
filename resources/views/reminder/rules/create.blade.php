<x-layouts.app :title="$rule->exists ? 'Edit Aturan' : 'Tambah Aturan'">
    <div class="max-w-2xl mx-auto">
        <a href="{{ route('reminder.rules.index') }}" class="inline-flex items-center text-sm text-gray-500 hover:text-gray-700 mb-4"><svg class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"/></svg> Kembali</a>
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6 shadow-sm">
            <h1 class="text-lg font-bold text-gray-900 dark:text-white mb-6">{{ $rule->exists ? 'Edit' : 'Tambah' }} Aturan Reminder</h1>
            <form method="POST" action="{{ $rule->exists ? route('reminder.rules.update', $rule) : route('reminder.rules.store') }}" class="space-y-4">
                @csrf @if($rule->exists) @method('PUT') @endif
                <div><label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nama</label><input type="text" name="name" value="{{ old('name', $rule->name) }}" required class="w-full rounded-lg border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-sm dark:text-white" placeholder="Pengingat H-7"></div>
                <div class="grid grid-cols-2 gap-4">
                    <div><label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Hari Sebelum Jatuh Tempo</label><input type="number" name="days_before_due" value="{{ old('days_before_due', $rule->days_before_due) }}" required class="w-full rounded-lg border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-sm dark:text-white"></div>
                    <div><label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Kode Template</label><input type="text" name="template_code" value="{{ old('template_code', $rule->template_code) }}" required class="w-full rounded-lg border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-sm dark:text-white" placeholder="h_minus_7"></div>
                </div>
                <div><label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Template Pesan</label><textarea name="template_text" rows="4" required class="w-full rounded-lg border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-sm dark:text-white" placeholder="Variabel: {nama} {nopol} {tanggal_jatuh_tempo}">{{ old('template_text', $rule->template_text) }}</textarea><p class="text-xs text-gray-400 mt-1">Gunakan {nama}, {nopol}, {tanggal_jatuh_tempo} sebagai variabel</p></div>
                <div class="grid grid-cols-2 gap-4">
                    <div><label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Jam Mulai Kirim</label><input type="time" name="send_window_start" value="{{ old('send_window_start', $rule->send_window_start ?? '08:00') }}" required class="w-full rounded-lg border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-sm dark:text-white"></div>
                    <div><label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Jam Akhir Kirim</label><input type="time" name="send_window_end" value="{{ old('send_window_end', $rule->send_window_end ?? '16:00') }}" required class="w-full rounded-lg border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-sm dark:text-white"></div>
                </div>
                <div class="flex items-center"><input type="checkbox" name="is_active" value="1" {{ old('is_active', $rule->is_active ?? true) ? 'checked' : '' }} class="w-4 h-4 rounded"><label class="ml-2 text-sm text-gray-700 dark:text-gray-300">Aktif</label></div>
                <button type="submit" class="w-full py-2.5 rounded-lg bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-medium text-sm hover:from-blue-500 hover:to-indigo-500 transition shadow-sm">Simpan</button>
            </form>
        </div>
    </div>
</x-layouts.app>
