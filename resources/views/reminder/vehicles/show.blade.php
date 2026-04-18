<x-layouts.app :title="'Detail Kendaraan'">
    {{-- Back --}}
    <div>
        <a href="{{ route('reminder.vehicles.index') }}" class="inline-flex items-center text-sm text-gray-500 hover:text-gray-700 mb-4">
            <svg class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
            Kembali ke Daftar Kendaraan
        </a>
    </div>

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6">
        <div>
            <h2 class="text-xl font-bold text-gray-900 dark:text-white">{{ $vehicle->plate_number }}</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">{{ $vehicle->brand ?? '' }} {{ $vehicle->vehicle_type ?? '' }} — Tahun {{ $vehicle->year ?? '-' }}</p>
        </div>
    </div>

    {{-- Info Cards --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 mb-6">
        {{-- Vehicle Info --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-5 shadow-sm">
            <h4 class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-3">Data Kendaraan</h4>
            <dl class="space-y-2 text-sm">
                <div class="flex justify-between"><dt class="text-gray-500 dark:text-gray-400">Nopol</dt><dd class="font-medium text-gray-900 dark:text-white">{{ $vehicle->plate_number }}</dd></div>
                <div class="flex justify-between"><dt class="text-gray-500 dark:text-gray-400">No. Registrasi</dt><dd class="font-medium text-gray-900 dark:text-white">{{ $vehicle->registration_number ?? '-' }}</dd></div>
                <div class="flex justify-between"><dt class="text-gray-500 dark:text-gray-400">Jenis</dt><dd class="font-medium text-gray-900 dark:text-white">{{ $vehicle->vehicle_type ?? '-' }}</dd></div>
                <div class="flex justify-between"><dt class="text-gray-500 dark:text-gray-400">Merek</dt><dd class="font-medium text-gray-900 dark:text-white">{{ $vehicle->brand ?? '-' }}</dd></div>
                <div class="flex justify-between"><dt class="text-gray-500 dark:text-gray-400">Tahun</dt><dd class="font-medium text-gray-900 dark:text-white">{{ $vehicle->year ?? '-' }}</dd></div>
            </dl>
        </div>

        {{-- Owner Info --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-5 shadow-sm">
            <h4 class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-3">Pemilik</h4>
            @if($vehicle->taxpayer)
            <dl class="space-y-2 text-sm">
                <div class="flex justify-between"><dt class="text-gray-500 dark:text-gray-400">Nama</dt>
                    <dd class="font-medium text-gray-900 dark:text-white">
                        <a href="{{ route('reminder.taxpayers.show', $vehicle->taxpayer) }}" class="text-blue-600 hover:underline">{{ $vehicle->taxpayer->name }}</a>
                    </dd>
                </div>
                <div class="flex justify-between"><dt class="text-gray-500 dark:text-gray-400">NIK</dt><dd class="font-medium text-gray-900 dark:text-white">{{ $vehicle->taxpayer->nik ?? '-' }}</dd></div>
                <div class="flex justify-between"><dt class="text-gray-500 dark:text-gray-400">Telepon</dt><dd class="font-medium text-gray-900 dark:text-white">{{ $vehicle->taxpayer->phone_e164 ?? '-' }}</dd></div>
                <div class="flex justify-between">
                    <dt class="text-gray-500 dark:text-gray-400">Opt-Out</dt>
                    <dd>
                        @if($vehicle->taxpayer->opt_out)
                            <span class="px-2 py-0.5 text-xs rounded-full bg-red-100 text-red-700">Ya</span>
                        @else
                            <span class="px-2 py-0.5 text-xs rounded-full bg-green-100 text-green-700">Tidak</span>
                        @endif
                    </dd>
                </div>
            </dl>
            @else
            <p class="text-sm text-gray-400">Data pemilik tidak tersedia</p>
            @endif
        </div>

        {{-- Due Date Info --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-5 shadow-sm">
            <h4 class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-3">Jatuh Tempo & Status</h4>
            <dl class="space-y-2 text-sm">
                <div class="flex justify-between"><dt class="text-gray-500 dark:text-gray-400">Jatuh Tempo</dt>
                    <dd class="font-medium text-gray-900 dark:text-white">{{ $vehicle->due_date?->format('d/m/Y') ?? '-' }}</dd>
                </div>
                <div class="flex justify-between"><dt class="text-gray-500 dark:text-gray-400">Status Pembayaran</dt>
                    <dd>
                        <span class="px-2 py-0.5 text-xs rounded-full
                            {{ ($vehicle->status_payment ?? '') === 'lunas' ? 'bg-green-100 text-green-700' : 'bg-amber-100 text-amber-700' }}">
                            {{ ucfirst($vehicle->status_payment ?? 'belum') }}
                        </span>
                    </dd>
                </div>
                <div class="flex justify-between"><dt class="text-gray-500 dark:text-gray-400">Total Reminder</dt>
                    <dd class="font-medium text-gray-900 dark:text-white">{{ $vehicle->reminderItems->count() }} item</dd>
                </div>
            </dl>
        </div>
    </div>

    {{-- Reminder History --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm">
        <div class="px-5 py-4 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-sm font-semibold text-gray-800 dark:text-gray-200">Riwayat Reminder</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 dark:bg-gray-700/50 text-xs text-gray-500 dark:text-gray-400 uppercase">
                    <tr>
                        <th class="px-4 py-2 text-left">Aturan</th>
                        <th class="px-4 py-2 text-left">Batch</th>
                        <th class="px-4 py-2 text-center">Tanggal Kirim</th>
                        <th class="px-4 py-2 text-center">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    @forelse($vehicle->reminderItems as $item)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30">
                        <td class="px-4 py-2 text-gray-900 dark:text-white">{{ $item->rule->name ?? '-' }}</td>
                        <td class="px-4 py-2 text-gray-600 dark:text-gray-300">
                            @if($item->batch)
                            <a href="{{ route('reminder.batches.show', $item->batch) }}" class="text-blue-600 hover:underline">Batch #{{ $item->batch->id }}</a>
                            @else
                            -
                            @endif
                        </td>
                        <td class="px-4 py-2 text-center text-gray-600 dark:text-gray-300">{{ $item->scheduled_at?->format('d/m/Y H:i') ?? '-' }}</td>
                        <td class="px-4 py-2 text-center">
                            @php
                                $statusColors = [
                                    'pending' => 'bg-gray-100 text-gray-700',
                                    'queued' => 'bg-blue-100 text-blue-700',
                                    'sent' => 'bg-green-100 text-green-700',
                                    'failed' => 'bg-red-100 text-red-700',
                                ];
                            @endphp
                            <span class="px-2 py-0.5 text-xs rounded-full {{ $statusColors[$item->status ?? ''] ?? 'bg-gray-100 text-gray-700' }}">
                                {{ ucfirst($item->status ?? 'pending') }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="px-4 py-8 text-center text-gray-400">Belum ada riwayat reminder</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-layouts.app>
