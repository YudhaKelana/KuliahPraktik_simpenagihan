<x-layouts.app :title="'Buat Batch Reminder'">
    <div class="max-w-2xl mx-auto">
        <a href="{{ route('reminder.batches.index') }}" class="inline-flex items-center text-sm text-gray-500 hover:text-gray-700 mb-4">
            <svg class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"/></svg> Kembali
        </a>

        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6 shadow-sm">
            <div class="flex items-center space-x-3 mb-6">
                <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-green-500 to-emerald-600 flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5"/></svg>
                </div>
                <div>
                    <h1 class="text-lg font-bold text-gray-900 dark:text-white">Buat Batch Reminder</h1>
                    <p class="text-xs text-gray-500">Kirim pengingat WhatsApp massal ke wajib pajak</p>
                </div>
            </div>

            {{-- Info Card --}}
            <div id="rule-info" class="hidden mb-4 p-4 rounded-lg bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-800 transition-all duration-300">
                <p class="text-xs font-semibold text-emerald-600 dark:text-emerald-400 uppercase tracking-wide mb-1">Aturan Terpilih</p>
                <p id="rule-detail" class="text-sm text-gray-700 dark:text-gray-300"></p>
            </div>

            <form method="POST" action="{{ route('reminder.batches.store') }}" class="space-y-4" id="batch-form">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Aturan Reminder <span class="text-red-500">*</span></label>
                    <select name="reminder_rule_id" required id="rule-select" class="w-full rounded-lg border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-sm dark:text-white">
                        <option value="">-- Pilih aturan --</option>
                        @foreach($rules as $rule)
                            <option value="{{ $rule->id }}" data-name="{{ $rule->name }}" data-days="{{ $rule->days_before_due }}" data-template="{{ $rule->template_code }}">
                                {{ $rule->name }} (H-{{ $rule->days_before_due }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Jatuh Tempo Dari <span class="text-red-500">*</span></label>
                        <input type="date" name="due_date_from" id="date-from" required class="w-full rounded-lg border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-sm dark:text-white">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Jatuh Tempo Sampai <span class="text-red-500">*</span></label>
                        <input type="date" name="due_date_to" id="date-to" required class="w-full rounded-lg border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-sm dark:text-white">
                        <p class="text-xs text-red-500 mt-1 hidden" id="date-range-error">Tanggal akhir harus setelah tanggal awal</p>
                    </div>
                </div>

                {{-- Date range preview --}}
                <div id="date-preview" class="hidden p-3 rounded-lg bg-gray-50 dark:bg-gray-700/50 text-sm text-gray-600 dark:text-gray-300">
                    <span class="font-medium">Rentang:</span> <span id="range-text"></span> · <span id="range-days" class="text-blue-600 font-medium"></span>
                </div>

                <div>
                    <div class="flex items-center justify-between mb-1">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Deskripsi Filter (opsional)</label>
                        <span class="text-xs text-gray-400" id="desc-counter">0 / 500</span>
                    </div>
                    <textarea name="filter_description" id="desc-input" rows="2" maxlength="500" class="w-full rounded-lg border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-sm dark:text-white" placeholder="Catatan tentang batch ini..."></textarea>
                </div>

                <button type="submit" id="submit-btn" class="w-full py-2.5 rounded-lg bg-gradient-to-r from-green-600 to-emerald-600 text-white font-medium text-sm hover:from-green-500 hover:to-emerald-500 transition shadow-sm disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center space-x-2">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5"/></svg>
                    <span>Generate Batch</span>
                </button>
            </form>
        </div>
    </div>

@push('scripts')
<script>
(function() {
    const ruleSelect = document.getElementById('rule-select');
    const ruleInfo = document.getElementById('rule-info');
    const dateFrom = document.getElementById('date-from');
    const dateTo = document.getElementById('date-to');
    const dateError = document.getElementById('date-range-error');
    const datePreview = document.getElementById('date-preview');
    const descInput = document.getElementById('desc-input');
    const descCounter = document.getElementById('desc-counter');

    // Rule info card
    ruleSelect.addEventListener('change', function() {
        const opt = this.selectedOptions[0];
        if (opt && opt.value) {
            document.getElementById('rule-detail').textContent =
                `${opt.dataset.name} · Kirim H-${opt.dataset.days} sebelum jatuh tempo · Template: ${opt.dataset.template}`;
            ruleInfo.classList.remove('hidden');
        } else {
            ruleInfo.classList.add('hidden');
        }
    });

    // Date range validation & preview
    function updateDateRange() {
        if (dateFrom.value && dateTo.value) {
            if (dateTo.value < dateFrom.value) {
                dateError.classList.remove('hidden');
                dateTo.classList.add('border-red-500');
                datePreview.classList.add('hidden');
                return;
            }
            dateError.classList.add('hidden');
            dateTo.classList.remove('border-red-500');

            const from = new Date(dateFrom.value);
            const to = new Date(dateTo.value);
            const days = Math.round((to - from) / (1000 * 60 * 60 * 24)) + 1;
            const opts = { day: 'numeric', month: 'short', year: 'numeric' };
            document.getElementById('range-text').textContent = from.toLocaleDateString('id-ID', opts) + ' – ' + to.toLocaleDateString('id-ID', opts);
            document.getElementById('range-days').textContent = days + ' hari';
            datePreview.classList.remove('hidden');
        } else {
            datePreview.classList.add('hidden');
        }
    }
    dateFrom.addEventListener('change', updateDateRange);
    dateTo.addEventListener('change', updateDateRange);

    // Character counter
    descInput.addEventListener('input', function() {
        const len = this.value.length;
        descCounter.textContent = len + ' / 500';
        descCounter.classList.toggle('text-red-500', len > 450);
    });

    // Submit loading
    document.getElementById('batch-form').addEventListener('submit', function(e) {
        if (dateTo.value && dateFrom.value && dateTo.value < dateFrom.value) { e.preventDefault(); return; }
        const btn = document.getElementById('submit-btn');
        btn.disabled = true;
        btn.innerHTML = '<svg class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg><span>Generating...</span>';
    });
})();
</script>
@endpush
</x-layouts.app>
