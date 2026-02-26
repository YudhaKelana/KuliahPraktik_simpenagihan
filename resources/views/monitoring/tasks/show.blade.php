<x-layouts.app :title="'Detail Tugas #' . $task->id">
    <div class="max-w-5xl mx-auto">
        {{-- Back --}}
        <a href="{{ route('monitoring.tasks.index') }}" class="inline-flex items-center text-sm text-gray-500 hover:text-gray-700 mb-4">
            <svg class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"/></svg>
            Kembali
        </a>

        {{-- Header Card --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6 mb-6 shadow-sm">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-4">
                <div>
                    <h1 class="text-xl font-bold text-gray-900 dark:text-white">{{ $task->arrearsItem->plate_number ?? '-' }}</h1>
                    <p class="text-sm text-gray-500 mt-0.5">{{ $task->arrearsItem->owner_name ?? '-' }} &bull; Tugas #{{ $task->id }}</p>
                </div>
                <div class="mt-3 sm:mt-0 flex items-center space-x-2">
                    @php $colors = ['new' => 'bg-gray-100 text-gray-700 border-gray-300', 'in_progress' => 'bg-blue-50 text-blue-700 border-blue-200', 'done' => 'bg-emerald-50 text-emerald-700 border-emerald-200']; @endphp
                    <span class="px-3 py-1 text-sm rounded-lg font-medium border {{ $colors[$task->status] }}">
                        {{ $task->status === 'new' ? 'Baru' : ($task->status === 'in_progress' ? 'Dalam Proses' : 'Selesai') }}
                    </span>
                    <a href="{{ route('monitoring.tasks.edit', $task) }}" class="px-3 py-1 text-sm rounded-lg bg-yellow-50 text-yellow-700 border border-yellow-200 hover:bg-yellow-100 transition font-medium">Edit</a>
                </div>
            </div>
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 text-sm">
                <div><span class="text-gray-500">PIC</span><p class="font-medium text-gray-900 dark:text-white">{{ $task->employee->name ?? '-' }}</p></div>
                <div><span class="text-gray-500">Tgl Tugas</span><p class="font-medium text-gray-900 dark:text-white">{{ $task->assigned_date?->format('d/m/Y') ?? '-' }}</p></div>
                <div><span class="text-gray-500">Umur</span><p class="font-medium text-gray-900 dark:text-white">{{ $task->age_days }} hari</p></div>
                <div><span class="text-gray-500">HP</span><p class="font-medium text-gray-900 dark:text-white">{{ $task->arrearsItem->masked_phone ?? '-' }}</p></div>
            </div>
            @if($task->arrearsItem?->arrears_amount > 0)
            <div class="mt-3 p-3 rounded-lg bg-red-50 dark:bg-red-900/20 text-sm">
                <span class="text-red-700 dark:text-red-300 font-medium">Tunggakan: Rp {{ number_format($task->arrearsItem->arrears_amount, 0, ',', '.') }}</span>
                @if($task->arrearsItem->arrears_years > 0)
                    <span class="text-red-500"> ({{ $task->arrearsItem->arrears_years }} tahun)</span>
                @endif
            </div>
            @endif
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            {{-- Follow-ups --}}
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm">
                <div class="px-5 py-4 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between">
                    <h3 class="text-sm font-semibold text-gray-800 dark:text-gray-200">Tindak Lanjut ({{ $task->followups->count() }})</h3>
                </div>
                {{-- Add Follow-up Form --}}
                <form method="POST" action="{{ route('monitoring.followups.store', $task) }}" class="p-4 bg-gray-50 dark:bg-gray-700/30 border-b border-gray-200 dark:border-gray-700">
                    @csrf
                    <div class="grid grid-cols-2 gap-3 mb-3">
                        <select name="type" required class="rounded-lg border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-sm dark:text-white">
                            <option value="telepon">📞 Telepon</option>
                            <option value="kunjungan">🚗 Kunjungan</option>
                        </select>
                        <input type="date" name="followup_date" value="{{ date('Y-m-d') }}" required class="rounded-lg border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-sm dark:text-white">
                    </div>
                    <textarea name="notes" rows="2" placeholder="Catatan..." class="w-full rounded-lg border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-sm mb-2 dark:text-white"></textarea>
                    <input type="text" name="result" placeholder="Hasil singkat (opsional)" class="w-full rounded-lg border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-sm mb-3 dark:text-white">
                    <button type="submit" class="w-full py-2 rounded-lg bg-blue-600 text-white text-sm font-medium hover:bg-blue-700 transition">Tambah Follow-up</button>
                </form>
                {{-- List --}}
                <div class="divide-y divide-gray-100 dark:divide-gray-700 max-h-80 overflow-y-auto">
                    @forelse($task->followups->sortByDesc('followup_date') as $fu)
                    <div class="px-4 py-3">
                        <div class="flex items-center justify-between mb-1">
                            <span class="text-xs font-medium {{ $fu->type === 'telepon' ? 'text-blue-600' : 'text-green-600' }}">
                                {{ $fu->type === 'telepon' ? '📞 Telepon' : '🚗 Kunjungan' }}
                            </span>
                            <span class="text-xs text-gray-400">{{ $fu->followup_date->format('d/m/Y') }}</span>
                        </div>
                        @if($fu->notes)<p class="text-sm text-gray-700 dark:text-gray-300">{{ $fu->notes }}</p>@endif
                        @if($fu->result)<p class="text-xs text-gray-500 mt-1">Hasil: {{ $fu->result }}</p>@endif
                    </div>
                    @empty
                    <p class="px-4 py-8 text-center text-gray-400 text-sm">Belum ada tindak lanjut</p>
                    @endforelse
                </div>
            </div>

            {{-- Vehicle Status --}}
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm">
                <div class="px-5 py-4 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-sm font-semibold text-gray-800 dark:text-gray-200">Status Kendaraan</h3>
                </div>
                {{-- Add Status Form --}}
                <form method="POST" action="{{ route('monitoring.vehicle-statuses.store', $task) }}" class="p-4 bg-gray-50 dark:bg-gray-700/30 border-b border-gray-200 dark:border-gray-700">
                    @csrf
                    <div class="grid grid-cols-2 gap-3 mb-3">
                        <select name="status" required class="rounded-lg border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-sm dark:text-white">
                            <option value="">-- Pilih Status --</option>
                            @foreach(\App\Models\VehicleStatus::STATUSES as $val => $label)
                                <option value="{{ $val }}">{{ $label }}</option>
                            @endforeach
                        </select>
                        <input type="date" name="status_date" value="{{ date('Y-m-d') }}" required class="rounded-lg border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-sm dark:text-white">
                    </div>
                    <textarea name="notes" rows="2" placeholder="Catatan..." class="w-full rounded-lg border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-sm mb-3 dark:text-white"></textarea>
                    <button type="submit" class="w-full py-2 rounded-lg bg-indigo-600 text-white text-sm font-medium hover:bg-indigo-700 transition">Simpan Status</button>
                </form>
                {{-- List --}}
                <div class="divide-y divide-gray-100 dark:divide-gray-700 max-h-80 overflow-y-auto">
                    @forelse($task->vehicleStatuses->sortByDesc('status_date') as $vs)
                    <div class="px-4 py-3">
                        <div class="flex items-center justify-between">
                            <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $vs->status_label }}</span>
                            <span class="text-xs text-gray-400">{{ $vs->status_date->format('d/m/Y') }}</span>
                        </div>
                        @if($vs->notes)<p class="text-xs text-gray-500 mt-1">{{ $vs->notes }}</p>@endif
                    </div>
                    @empty
                    <p class="px-4 py-8 text-center text-gray-400 text-sm">Belum ada status kendaraan</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
