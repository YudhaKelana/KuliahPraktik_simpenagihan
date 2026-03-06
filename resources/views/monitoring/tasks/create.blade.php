<x-layouts.app :title="'Buat Tugas Baru'">
    <div class="max-w-2xl mx-auto">
        <a href="{{ route('monitoring.tasks.index') }}" class="inline-flex items-center text-sm text-gray-500 hover:text-gray-700 mb-4">
            <svg class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"/></svg> Kembali
        </a>

        {{-- Progress Steps --}}
        <div class="flex items-center justify-between mb-6 px-2" id="progress-bar">
            <div class="flex items-center space-x-2" data-step="1">
                <div class="w-8 h-8 rounded-full bg-blue-600 text-white flex items-center justify-center text-xs font-bold transition-all duration-300">1</div>
                <span class="text-xs font-medium text-blue-600 hidden sm:inline">Tunggakan</span>
            </div>
            <div class="flex-1 h-0.5 bg-gray-200 mx-2 transition-all duration-500" id="prog-line-1"></div>
            <div class="flex items-center space-x-2" data-step="2">
                <div class="w-8 h-8 rounded-full bg-gray-200 text-gray-500 flex items-center justify-center text-xs font-bold transition-all duration-300">2</div>
                <span class="text-xs font-medium text-gray-400 hidden sm:inline">Penugasan</span>
            </div>
            <div class="flex-1 h-0.5 bg-gray-200 mx-2 transition-all duration-500" id="prog-line-2"></div>
            <div class="flex items-center space-x-2" data-step="3">
                <div class="w-8 h-8 rounded-full bg-gray-200 text-gray-500 flex items-center justify-center text-xs font-bold transition-all duration-300">3</div>
                <span class="text-xs font-medium text-gray-400 hidden sm:inline">Detail</span>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6 shadow-sm">
            <h1 class="text-lg font-bold text-gray-900 dark:text-white mb-6">Buat Tugas Baru</h1>

            {{-- Info panel --}}
            <div id="selected-info" class="hidden mb-4 p-4 rounded-lg bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 transition-all duration-300">
                <p class="text-xs font-semibold text-blue-600 dark:text-blue-400 uppercase tracking-wide mb-2">Data Kendaraan Terpilih</p>
                <div class="grid grid-cols-2 gap-2 text-sm">
                    <div><span class="text-gray-500">Nopol:</span> <span id="info-nopol" class="font-medium text-gray-900 dark:text-white">-</span></div>
                    <div><span class="text-gray-500">Pemilik:</span> <span id="info-owner" class="font-medium text-gray-900 dark:text-white">-</span></div>
                    <div><span class="text-gray-500">Tunggakan:</span> <span id="info-amount" class="font-medium text-red-600">-</span></div>
                    <div><span class="text-gray-500">HP:</span> <span id="info-phone" class="font-medium text-gray-900 dark:text-white">-</span></div>
                </div>
            </div>

            <form method="POST" action="{{ route('monitoring.tasks.store') }}" class="space-y-4" id="task-form">
                @csrf
                {{-- Tunggakan --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Data Tunggakan <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <input type="text" id="arrears-search" placeholder="Ketik nopol atau nama pemilik untuk mencari..." autocomplete="off"
                               class="w-full rounded-lg border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-sm dark:text-white pl-9 focus:ring-blue-500 focus:border-blue-500">
                        <svg class="w-4 h-4 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/></svg>
                    </div>
                    <select name="arrears_item_id" required id="arrears-select" class="w-full rounded-lg border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-sm dark:text-white mt-2">
                        <option value="">-- Pilih kendaraan --</option>
                        @foreach($arrearsItems as $item)
                            <option value="{{ $item->id }}"
                                    data-nopol="{{ $item->plate_number }}"
                                    data-owner="{{ $item->owner_name ?? 'N/A' }}"
                                    data-amount="{{ number_format($item->arrears_amount, 0, ',', '.') }}"
                                    data-phone="{{ $item->phone ?? '-' }}">
                                {{ $item->plate_number }} — {{ $item->owner_name ?? 'N/A' }}
                            </option>
                        @endforeach
                    </select>
                    @error('arrears_item_id')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                </div>

                {{-- PIC --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">PIC / Pegawai</label>
                    <select name="employee_id" id="employee-select" class="w-full rounded-lg border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-sm dark:text-white">
                        <option value="">-- Belum ditentukan --</option>
                        @foreach($employees as $emp)
                            <option value="{{ $emp->id }}">{{ $emp->name }} ({{ $emp->jabatan ?? '-' }})</option>
                        @endforeach
                    </select>
                </div>

                {{-- Dates --}}
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tanggal Tugas <span class="text-red-500">*</span></label>
                        <input type="date" name="assigned_date" id="assigned-date" value="{{ date('Y-m-d') }}" required class="w-full rounded-lg border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-sm dark:text-white">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Batas Waktu</label>
                        <input type="date" name="due_date" id="due-date" class="w-full rounded-lg border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-sm dark:text-white">
                        <p class="text-xs text-red-500 mt-1 hidden" id="date-error">Batas waktu harus setelah tanggal tugas</p>
                    </div>
                </div>

                {{-- Notes --}}
                <div>
                    <div class="flex items-center justify-between mb-1">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Catatan</label>
                        <span class="text-xs text-gray-400" id="notes-counter">0 / 1000</span>
                    </div>
                    <textarea name="notes" id="notes-input" rows="3" maxlength="1000" class="w-full rounded-lg border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-sm dark:text-white" placeholder="Tambahkan catatan opsional..."></textarea>
                </div>

                <button type="submit" id="submit-btn" class="w-full py-2.5 rounded-lg bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-medium text-sm hover:from-blue-500 hover:to-indigo-500 transition shadow-sm disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center space-x-2">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                    <span>Simpan Tugas</span>
                </button>
            </form>
        </div>
    </div>

@push('scripts')
<script>
(function() {
    const searchInput = document.getElementById('arrears-search');
    const select = document.getElementById('arrears-select');
    const infoPanel = document.getElementById('selected-info');
    const notesInput = document.getElementById('notes-input');
    const notesCounter = document.getElementById('notes-counter');
    const assignedDate = document.getElementById('assigned-date');
    const dueDate = document.getElementById('due-date');
    const dateError = document.getElementById('date-error');
    const allOptions = Array.from(select.options);

    // Live search filter for arrears dropdown
    searchInput.addEventListener('input', function() {
        const q = this.value.toLowerCase();
        select.innerHTML = '';
        const placeholder = document.createElement('option');
        placeholder.value = '';
        placeholder.textContent = q ? `Hasil pencarian "${this.value}"...` : '-- Pilih kendaraan --';
        select.appendChild(placeholder);

        allOptions.forEach(opt => {
            if (!opt.value) return;
            if (opt.textContent.toLowerCase().includes(q)) {
                select.appendChild(opt.cloneNode(true));
            }
        });
    });

    // Show info panel on select
    select.addEventListener('change', function() {
        const opt = this.selectedOptions[0];
        if (opt && opt.value) {
            document.getElementById('info-nopol').textContent = opt.dataset.nopol;
            document.getElementById('info-owner').textContent = opt.dataset.owner;
            document.getElementById('info-amount').textContent = 'Rp ' + opt.dataset.amount;
            document.getElementById('info-phone').textContent = opt.dataset.phone;
            infoPanel.classList.remove('hidden');
            infoPanel.style.animation = 'fadeInUp .3s ease';
            updateProgress(2);
        } else {
            infoPanel.classList.add('hidden');
            updateProgress(1);
        }
    });

    // Character counter
    notesInput.addEventListener('input', function() {
        const len = this.value.length;
        notesCounter.textContent = len + ' / 1000';
        notesCounter.classList.toggle('text-red-500', len > 900);
        notesCounter.classList.toggle('text-gray-400', len <= 900);
    });

    // Date validation
    function checkDates() {
        if (dueDate.value && assignedDate.value && dueDate.value < assignedDate.value) {
            dateError.classList.remove('hidden');
            dueDate.classList.add('border-red-500');
            return false;
        }
        dateError.classList.add('hidden');
        dueDate.classList.remove('border-red-500');
        return true;
    }
    dueDate.addEventListener('change', checkDates);
    assignedDate.addEventListener('change', checkDates);

    // Progress bar
    function updateProgress(step) {
        for (let i = 1; i <= 3; i++) {
            const el = document.querySelector(`[data-step="${i}"]`);
            const circle = el.querySelector('div');
            const label = el.querySelector('span');
            if (i <= step) {
                circle.classList.remove('bg-gray-200', 'text-gray-500');
                circle.classList.add('bg-blue-600', 'text-white');
                if (label) { label.classList.remove('text-gray-400'); label.classList.add('text-blue-600'); }
            } else {
                circle.classList.add('bg-gray-200', 'text-gray-500');
                circle.classList.remove('bg-blue-600', 'text-white');
                if (label) { label.classList.add('text-gray-400'); label.classList.remove('text-blue-600'); }
            }
        }
        for (let i = 1; i < 3; i++) {
            const line = document.getElementById('prog-line-' + i);
            line.classList.toggle('bg-blue-600', i < step);
            line.classList.toggle('bg-gray-200', i >= step);
        }
    }

    // Track filling
    const employeeSelect = document.getElementById('employee-select');
    [employeeSelect, assignedDate, dueDate, notesInput].forEach(el => {
        el.addEventListener('change', () => {
            if (select.value) updateProgress(assignedDate.value ? 3 : 2);
        });
        el.addEventListener('input', () => {
            if (select.value) updateProgress(assignedDate.value ? 3 : 2);
        });
    });

    // Submit with loading state
    document.getElementById('task-form').addEventListener('submit', function(e) {
        if (!checkDates()) { e.preventDefault(); return; }
        const btn = document.getElementById('submit-btn');
        btn.disabled = true;
        btn.innerHTML = '<svg class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg><span>Menyimpan...</span>';
    });

    // CSS for fadeInUp
    const style = document.createElement('style');
    style.textContent = '@keyframes fadeInUp { from { opacity:0; transform:translateY(8px); } to { opacity:1; transform:translateY(0); } }';
    document.head.appendChild(style);
})();
</script>
@endpush
</x-layouts.app>
