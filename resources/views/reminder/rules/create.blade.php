<x-layouts.app :title="$rule->exists ? 'Edit Aturan' : 'Tambah Aturan'">
    <div class="max-w-2xl mx-auto">
        <a href="{{ route('reminder.rules.index') }}" class="inline-flex items-center text-sm text-gray-500 hover:text-gray-700 mb-4">
            <svg class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"/></svg> Kembali
        </a>

        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6 shadow-sm">
            <div class="flex items-center space-x-3 mb-6">
                <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-purple-500 to-indigo-600 flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6h9.75M10.5 6a1.5 1.5 0 11-3 0m3 0a1.5 1.5 0 10-3 0M3.75 6H7.5m3 12h9.75m-9.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-3.75 0H7.5m9-6h3.75m-3.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-9.75 0h9.75"/></svg>
                </div>
                <div>
                    <h1 class="text-lg font-bold text-gray-900 dark:text-white">{{ $rule->exists ? 'Edit' : 'Tambah' }} Aturan Reminder</h1>
                    <p class="text-xs text-gray-500">Konfigurasi template pesan & jadwal pengiriman</p>
                </div>
            </div>

            <form method="POST" action="{{ $rule->exists ? route('reminder.rules.update', $rule) : route('reminder.rules.store') }}" class="space-y-4" id="rule-form">
                @csrf @if($rule->exists) @method('PUT') @endif

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nama <span class="text-red-500">*</span></label>
                    <input type="text" name="name" id="rule-name" value="{{ old('name', $rule->name) }}" required
                           class="w-full rounded-lg border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-sm dark:text-white focus:ring-blue-500 focus:border-blue-500"
                           placeholder="Pengingat H-7">
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Hari Sebelum Jatuh Tempo <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <input type="number" name="days_before_due" id="days-input" value="{{ old('days_before_due', $rule->days_before_due) }}" required min="1" max="365"
                                   class="w-full rounded-lg border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-sm dark:text-white focus:ring-blue-500 focus:border-blue-500 pr-12">
                            <span class="absolute right-3 top-1/2 -translate-y-1/2 text-xs text-gray-400">hari</span>
                        </div>
                        <p class="text-xs text-gray-400 mt-1" id="days-hint"></p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Kode Template <span class="text-red-500">*</span></label>
                        <input type="text" name="template_code" id="template-code" value="{{ old('template_code', $rule->template_code) }}" required
                               class="w-full rounded-lg border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-sm dark:text-white font-mono focus:ring-blue-500 focus:border-blue-500"
                               placeholder="h_minus_7">
                    </div>
                </div>

                <div>
                    <div class="flex items-center justify-between mb-1">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Template Pesan <span class="text-red-500">*</span></label>
                        <span class="text-xs text-gray-400" id="template-counter">{{ strlen(old('template_text', $rule->template_text ?? '')) }} karakter</span>
                    </div>
                    <textarea name="template_text" id="template-text" rows="5" required
                              class="w-full rounded-lg border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-sm dark:text-white font-mono focus:ring-blue-500 focus:border-blue-500"
                              placeholder="Yth {nama}, kendaraan {nopol} Anda memiliki tunggakan yang jatuh tempo pada {tanggal_jatuh_tempo}.">{{ old('template_text', $rule->template_text) }}</textarea>

                    {{-- Variable buttons --}}
                    <div class="flex flex-wrap gap-1.5 mt-2">
                        <span class="text-xs text-gray-500 py-1">Variabel:</span>
                        <button type="button" class="var-btn px-2 py-1 text-xs rounded-md bg-blue-50 text-blue-600 hover:bg-blue-100 border border-blue-200 transition font-mono" data-var="{nama}">
                            {nama}
                        </button>
                        <button type="button" class="var-btn px-2 py-1 text-xs rounded-md bg-green-50 text-green-600 hover:bg-green-100 border border-green-200 transition font-mono" data-var="{nopol}">
                            {nopol}
                        </button>
                        <button type="button" class="var-btn px-2 py-1 text-xs rounded-md bg-amber-50 text-amber-600 hover:bg-amber-100 border border-amber-200 transition font-mono" data-var="{tanggal_jatuh_tempo}">
                            {tanggal_jatuh_tempo}
                        </button>
                    </div>

                    {{-- Preview --}}
                    <div class="mt-3 p-3 rounded-lg bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-800">
                        <p class="text-xs font-semibold text-emerald-600 uppercase tracking-wide mb-1">Preview Pesan</p>
                        <p class="text-sm text-gray-700 dark:text-gray-300 whitespace-pre-wrap" id="message-preview">-</p>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Jam Mulai Kirim <span class="text-red-500">*</span></label>
                        <input type="time" name="send_window_start" id="time-start" value="{{ old('send_window_start', $rule->send_window_start ?? '08:00') }}" required
                               class="w-full rounded-lg border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-sm dark:text-white">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Jam Akhir Kirim <span class="text-red-500">*</span></label>
                        <input type="time" name="send_window_end" id="time-end" value="{{ old('send_window_end', $rule->send_window_end ?? '16:00') }}" required
                               class="w-full rounded-lg border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-sm dark:text-white">
                        <p class="text-xs text-red-500 mt-1 hidden" id="time-error">Jam akhir harus setelah jam mulai</p>
                    </div>
                </div>

                {{-- Time window preview --}}
                <div id="time-preview" class="p-3 rounded-lg bg-gray-50 dark:bg-gray-700/50 text-sm text-gray-600 dark:text-gray-300">
                    <span class="font-medium">Window pengiriman:</span> <span id="time-window-text">08:00 – 16:00 (8 jam)</span>
                </div>

                <div class="flex items-center p-3 rounded-lg bg-gray-50 dark:bg-gray-700/50 border border-gray-200 dark:border-gray-600">
                    <input type="checkbox" name="is_active" value="1" id="active-check" {{ old('is_active', $rule->is_active ?? true) ? 'checked' : '' }}
                           class="w-4 h-4 rounded text-blue-600 focus:ring-blue-500">
                    <label for="active-check" class="ml-2 text-sm text-gray-700 dark:text-gray-300">Aturan ini <span class="font-medium" id="active-label">aktif</span></label>
                </div>

                <button type="submit" id="submit-btn" class="w-full py-2.5 rounded-lg bg-gradient-to-r from-purple-600 to-indigo-600 text-white font-medium text-sm hover:from-purple-500 hover:to-indigo-500 transition shadow-sm disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center space-x-2">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                    <span>Simpan</span>
                </button>
            </form>
        </div>
    </div>

@push('scripts')
<script>
(function() {
    const templateText = document.getElementById('template-text');
    const templateCounter = document.getElementById('template-counter');
    const preview = document.getElementById('message-preview');
    const daysInput = document.getElementById('days-input');
    const daysHint = document.getElementById('days-hint');
    const nameInput = document.getElementById('rule-name');
    const codeInput = document.getElementById('template-code');
    const timeStart = document.getElementById('time-start');
    const timeEnd = document.getElementById('time-end');
    const timeError = document.getElementById('time-error');
    const activeCheck = document.getElementById('active-check');
    const activeLabel = document.getElementById('active-label');

    // Message preview
    function updatePreview() {
        let text = templateText.value || '-';
        text = text.replace(/\{nama\}/g, 'Budi Santoso');
        text = text.replace(/\{nopol\}/g, 'BP 1234 AB');
        text = text.replace(/\{tanggal_jatuh_tempo\}/g, '15/03/2026');
        preview.textContent = text;
        templateCounter.textContent = templateText.value.length + ' karakter';
    }
    templateText.addEventListener('input', updatePreview);
    updatePreview();

    // Variable insertion buttons
    document.querySelectorAll('.var-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const variable = this.dataset.var;
            const start = templateText.selectionStart;
            const end = templateText.selectionEnd;
            const text = templateText.value;
            templateText.value = text.substring(0, start) + variable + text.substring(end);
            templateText.selectionStart = templateText.selectionEnd = start + variable.length;
            templateText.focus();
            updatePreview();
        });
    });

    // Days hint
    daysInput.addEventListener('input', function() {
        const days = parseInt(this.value);
        if (days > 0) {
            daysHint.textContent = `Pesan dikirim H-${days} sebelum jatuh tempo`;
        } else {
            daysHint.textContent = '';
        }
    });
    daysInput.dispatchEvent(new Event('input'));

    // Auto generate code from name
    nameInput.addEventListener('input', function() {
        if (!codeInput.dataset.edited) {
            codeInput.value = this.value.toLowerCase().replace(/\s+/g, '_').replace(/[^a-z0-9_]/g, '');
        }
    });
    codeInput.addEventListener('input', function() {
        this.dataset.edited = '1';
    });

    // Time validation
    function checkTime() {
        if (timeStart.value && timeEnd.value) {
            if (timeEnd.value <= timeStart.value) {
                timeError.classList.remove('hidden');
                return;
            }
            timeError.classList.add('hidden');
            // Calculate window
            const [h1, m1] = timeStart.value.split(':').map(Number);
            const [h2, m2] = timeEnd.value.split(':').map(Number);
            const hours = (h2 * 60 + m2 - h1 * 60 - m1) / 60;
            document.getElementById('time-window-text').textContent =
                `${timeStart.value} – ${timeEnd.value} (${Math.floor(hours)} jam ${Math.round((hours % 1) * 60)} menit)`;
        }
    }
    timeStart.addEventListener('change', checkTime);
    timeEnd.addEventListener('change', checkTime);
    checkTime();

    // Active toggle
    activeCheck.addEventListener('change', function() {
        activeLabel.textContent = this.checked ? 'aktif' : 'nonaktif';
        activeLabel.classList.toggle('text-emerald-600', this.checked);
        activeLabel.classList.toggle('text-red-600', !this.checked);
    });
    activeCheck.dispatchEvent(new Event('change'));

    // Submit loading
    document.getElementById('rule-form').addEventListener('submit', function(e) {
        if (timeEnd.value && timeStart.value && timeEnd.value <= timeStart.value) { e.preventDefault(); return; }
        const btn = document.getElementById('submit-btn');
        btn.disabled = true;
        btn.innerHTML = '<svg class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg><span>Menyimpan...</span>';
    });
})();
</script>
@endpush
</x-layouts.app>
