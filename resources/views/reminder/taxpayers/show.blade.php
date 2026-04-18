<x-layouts.app :title="'Detail Wajib Pajak'">
    {{-- Back --}}
    <div>
        <a href="{{ route('reminder.taxpayers.index') }}" class="inline-flex items-center text-sm text-gray-500 hover:text-gray-700 mb-4">
            <svg class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
            Kembali ke Daftar WP
        </a>
    </div>

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6">
        <div>
            <h2 class="text-xl font-bold text-gray-900 dark:text-white">{{ $taxpayer->name }}</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">NIK: {{ $taxpayer->nik ?? '-' }}</p>
        </div>
        <div class="flex items-center gap-2 mt-3 sm:mt-0">
            <a href="{{ route('reminder.taxpayers.edit', $taxpayer) }}" class="px-3 py-1 text-sm rounded-lg bg-yellow-50 text-yellow-700 border border-yellow-200 hover:bg-yellow-100 transition font-medium">Edit</a>
            <form method="POST" action="{{ route('reminder.taxpayers.toggle-optout', $taxpayer) }}" class="inline">@csrf
                <button type="submit" class="px-3 py-1 text-sm rounded-lg {{ $taxpayer->opt_out ? 'bg-green-50 text-green-700 border border-green-200 hover:bg-green-100' : 'bg-red-50 text-red-700 border border-red-200 hover:bg-red-100' }} transition font-medium">
                    {{ $taxpayer->opt_out ? 'Cabut Opt-Out' : 'Opt-Out' }}
                </button>
            </form>
        </div>
    </div>

    {{-- Info Cards --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 mb-6">
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-5 shadow-sm">
            <h4 class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-3">Informasi Kontak</h4>
            <dl class="space-y-2 text-sm">
                <div class="flex justify-between"><dt class="text-gray-500 dark:text-gray-400">Telepon</dt><dd class="font-medium text-gray-900 dark:text-white">{{ $taxpayer->phone_e164 ?? '-' }}</dd></div>
                <div class="flex justify-between"><dt class="text-gray-500 dark:text-gray-400">Alamat</dt><dd class="font-medium text-gray-900 dark:text-white text-right max-w-[200px]">{{ $taxpayer->address ?? '-' }}</dd></div>
                <div class="flex justify-between"><dt class="text-gray-500 dark:text-gray-400">Kecamatan</dt><dd class="font-medium text-gray-900 dark:text-white">{{ $taxpayer->district ?? '-' }}</dd></div>
                <div class="flex justify-between"><dt class="text-gray-500 dark:text-gray-400">Kelurahan</dt><dd class="font-medium text-gray-900 dark:text-white">{{ $taxpayer->village ?? '-' }}</dd></div>
            </dl>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-5 shadow-sm">
            <h4 class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-3">Status</h4>
            <dl class="space-y-2 text-sm">
                <div class="flex justify-between">
                    <dt class="text-gray-500 dark:text-gray-400">Opt-Out</dt>
                    <dd>
                        @if($taxpayer->opt_out)
                            <span class="px-2 py-0.5 text-xs rounded-full bg-red-100 text-red-700">Ya</span>
                        @else
                            <span class="px-2 py-0.5 text-xs rounded-full bg-green-100 text-green-700">Tidak</span>
                        @endif
                    </dd>
                </div>
                @if($taxpayer->opt_out_at)
                <div class="flex justify-between"><dt class="text-gray-500 dark:text-gray-400">Opt-Out sejak</dt><dd class="font-medium text-gray-900 dark:text-white">{{ $taxpayer->opt_out_at->format('d/m/Y H:i') }}</dd></div>
                @endif
                <div class="flex justify-between"><dt class="text-gray-500 dark:text-gray-400">Jumlah Kendaraan</dt><dd class="font-medium text-gray-900 dark:text-white">{{ $taxpayer->vehicles->count() }}</dd></div>
            </dl>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-5 shadow-sm">
            <h4 class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-3">Data Sistem</h4>
            <dl class="space-y-2 text-sm">
                <div class="flex justify-between"><dt class="text-gray-500 dark:text-gray-400">ID</dt><dd class="font-medium text-gray-900 dark:text-white">#{{ $taxpayer->id }}</dd></div>
                <div class="flex justify-between"><dt class="text-gray-500 dark:text-gray-400">Dibuat</dt><dd class="font-medium text-gray-900 dark:text-white">{{ $taxpayer->created_at?->format('d/m/Y') ?? '-' }}</dd></div>
                <div class="flex justify-between"><dt class="text-gray-500 dark:text-gray-400">Diupdate</dt><dd class="font-medium text-gray-900 dark:text-white">{{ $taxpayer->updated_at?->format('d/m/Y') ?? '-' }}</dd></div>
            </dl>
        </div>
    </div>

    {{-- Vehicles --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm">
        <div class="px-5 py-4 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-sm font-semibold text-gray-800 dark:text-gray-200">Daftar Kendaraan</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 dark:bg-gray-700/50 text-xs text-gray-500 dark:text-gray-400 uppercase">
                    <tr>
                        <th class="px-4 py-2 text-left">Nopol</th>
                        <th class="px-4 py-2 text-left">Jenis</th>
                        <th class="px-4 py-2 text-left">Merek</th>
                        <th class="px-4 py-2 text-center">Jatuh Tempo</th>
                        <th class="px-4 py-2 text-center">Status</th>
                        <th class="px-4 py-2 text-center">Reminder</th>
                        <th class="px-4 py-2 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    @forelse($taxpayer->vehicles as $vehicle)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30">
                        <td class="px-4 py-2 font-medium text-gray-900 dark:text-white">{{ $vehicle->plate_number }}</td>
                        <td class="px-4 py-2 text-gray-600 dark:text-gray-300">{{ $vehicle->vehicle_type ?? '-' }}</td>
                        <td class="px-4 py-2 text-gray-600 dark:text-gray-300">{{ $vehicle->brand ?? '-' }}</td>
                        <td class="px-4 py-2 text-center text-gray-600 dark:text-gray-300">{{ $vehicle->due_date?->format('d/m/Y') ?? '-' }}</td>
                        <td class="px-4 py-2 text-center">
                            <span class="px-2 py-0.5 text-xs rounded-full
                                {{ ($vehicle->status_payment ?? '') === 'lunas' ? 'bg-green-100 text-green-700' : 'bg-amber-100 text-amber-700' }}">
                                {{ ucfirst($vehicle->status_payment ?? 'belum') }}
                            </span>
                        </td>
                        <td class="px-4 py-2 text-center text-gray-500">{{ $vehicle->reminderItems->count() }}</td>
                        <td class="px-4 py-2 text-center">
                            <a href="{{ route('reminder.vehicles.show', $vehicle) }}" class="text-blue-600 hover:underline text-xs font-medium">Detail</a>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="7" class="px-4 py-8 text-center text-gray-400">Belum ada data kendaraan</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-layouts.app>
