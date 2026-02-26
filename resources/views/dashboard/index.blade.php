<x-layouts.app :title="'Dashboard'">
    {{-- KPI Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        {{-- Total Tunggakan --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-5 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0zm3 0h.008v.008H18V10.5zm-12 0h.008v.008H6V10.5z"/></svg>
                </div>
                <span class="text-xs font-medium text-blue-600 dark:text-blue-400 bg-blue-50 dark:bg-blue-900/30 px-2 py-1 rounded-full">Tunggakan</span>
            </div>
            <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ number_format($totalArrears) }}</p>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Total data &bull; Rp {{ number_format($totalArrearAmount, 0, ',', '.') }}</p>
        </div>

        {{-- Total Tugas --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-5 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-indigo-500 to-indigo-600 flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25z"/></svg>
                </div>
                <span class="text-xs font-medium text-indigo-600 dark:text-indigo-400 bg-indigo-50 dark:bg-indigo-900/30 px-2 py-1 rounded-full">Tugas</span>
            </div>
            <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ number_format($totalTasks) }}</p>
            <div class="flex space-x-3 mt-1 text-xs text-gray-500 dark:text-gray-400">
                <span class="text-emerald-600">✓ {{ $tasksByStatus['done'] ?? 0 }}</span>
                <span class="text-amber-600">⟳ {{ $tasksByStatus['in_progress'] ?? 0 }}</span>
                <span class="text-gray-400">● {{ $tasksByStatus['new'] ?? 0 }} baru</span>
            </div>
        </div>

        {{-- Follow-up Hari Ini --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-5 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-emerald-500 to-emerald-600 flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z"/></svg>
                </div>
                <span class="text-xs font-medium text-emerald-600 dark:text-emerald-400 bg-emerald-50 dark:bg-emerald-900/30 px-2 py-1 rounded-full">Follow-up</span>
            </div>
            <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ number_format($todayFollowups) }}</p>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Hari ini &bull; {{ number_format($totalFollowups) }} total</p>
        </div>

        {{-- Alert --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-5 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-red-500 to-orange-500 flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/></svg>
                </div>
                <span class="text-xs font-medium text-red-600 dark:text-red-400 bg-red-50 dark:bg-red-900/30 px-2 py-1 rounded-full">Peringatan</span>
            </div>
            <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $overdueTasks->count() + $missingStatus->count() }}</p>
            <div class="flex space-x-3 mt-1 text-xs text-gray-500 dark:text-gray-400">
                <span class="text-red-600">{{ $overdueTasks->count() }} overdue</span>
                <span class="text-amber-600">{{ $incompleteData }} data ↓</span>
            </div>
        </div>
    </div>

    {{-- Charts Row — fixed height wrapper to prevent infinite growth --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 mb-6">
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-5 shadow-sm">
            <h3 class="text-sm font-semibold text-gray-800 dark:text-gray-200 mb-4">Distribusi Status Kendaraan</h3>
            <div class="relative" style="height: 250px;">
                <canvas id="statusChart"></canvas>
            </div>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-5 shadow-sm">
            <h3 class="text-sm font-semibold text-gray-800 dark:text-gray-200 mb-4">Tren Follow-up (7 Hari Terakhir)</h3>
            <div class="relative" style="height: 250px;">
                <canvas id="followupChart"></canvas>
            </div>
        </div>
    </div>

    {{-- Reminder Stats --}}
    <div class="grid grid-cols-1 sm:grid-cols-4 gap-4 mb-6">
        <div class="bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl p-4 text-white shadow-sm">
            <p class="text-xs opacity-80 uppercase tracking-wide">WA Terkirim Hari Ini</p>
            <p class="text-2xl font-bold mt-1">{{ $reminderStats['sent_today'] }}</p>
        </div>
        <div class="bg-gradient-to-br from-red-500 to-pink-600 rounded-xl p-4 text-white shadow-sm">
            <p class="text-xs opacity-80 uppercase tracking-wide">Gagal Hari Ini</p>
            <p class="text-2xl font-bold mt-1">{{ $reminderStats['failed_today'] }}</p>
        </div>
        <div class="bg-gradient-to-br from-amber-500 to-orange-600 rounded-xl p-4 text-white shadow-sm">
            <p class="text-xs opacity-80 uppercase tracking-wide">Batch Menunggu</p>
            <p class="text-2xl font-bold mt-1">{{ $reminderStats['pending'] }}</p>
        </div>
        <div class="bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl p-4 text-white shadow-sm">
            <p class="text-xs opacity-80 uppercase tracking-wide">Total Batch</p>
            <p class="text-2xl font-bold mt-1">{{ $reminderStats['total_batches'] }}</p>
        </div>
    </div>

    {{-- Priority Tables --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 mb-6">
        {{-- Overdue --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm">
            <div class="px-5 py-4 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between">
                <h3 class="text-sm font-semibold text-gray-800 dark:text-gray-200 flex items-center">
                    <span class="w-2 h-2 bg-red-500 rounded-full mr-2 animate-pulse"></span>
                    Tugas Overdue
                </h3>
                <a href="{{ route('monitoring.tasks.index', ['flag' => 'overdue']) }}" class="text-xs text-blue-600 hover:underline">Lihat semua →</a>
            </div>
            <div class="overflow-x-auto max-h-64 overflow-y-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 dark:bg-gray-700/50 text-xs text-gray-500 dark:text-gray-400 uppercase sticky top-0">
                        <tr><th class="px-4 py-2 text-left">Nopol</th><th class="px-4 py-2 text-left">PIC</th><th class="px-4 py-2 text-center">Umur</th><th class="px-4 py-2 text-center">Level</th></tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                        @forelse($overdueTasks as $t)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30">
                            <td class="px-4 py-2 font-medium text-gray-900 dark:text-white">{{ $t->arrearsItem->plate_number ?? '-' }}</td>
                            <td class="px-4 py-2 text-gray-600 dark:text-gray-300">{{ $t->employee->name ?? '-' }}</td>
                            <td class="px-4 py-2 text-center">{{ $t->age_days }} hari</td>
                            <td class="px-4 py-2 text-center">
                                @if($t->age_days >= $criticalDays)
                                    <span class="px-2 py-0.5 text-xs rounded-full bg-red-100 text-red-700">Kritis</span>
                                @else
                                    <span class="px-2 py-0.5 text-xs rounded-full bg-amber-100 text-amber-700">Peringatan</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="4" class="px-4 py-8 text-center text-gray-400">Tidak ada tugas overdue 🎉</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Missing Status --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm">
            <div class="px-5 py-4 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between">
                <h3 class="text-sm font-semibold text-gray-800 dark:text-gray-200 flex items-center">
                    <span class="w-2 h-2 bg-amber-500 rounded-full mr-2"></span>
                    Belum Input Status
                </h3>
                <a href="{{ route('monitoring.tasks.index', ['flag' => 'missing_status']) }}" class="text-xs text-blue-600 hover:underline">Lihat semua →</a>
            </div>
            <div class="overflow-x-auto max-h-64 overflow-y-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 dark:bg-gray-700/50 text-xs text-gray-500 dark:text-gray-400 uppercase sticky top-0">
                        <tr><th class="px-4 py-2 text-left">Nopol</th><th class="px-4 py-2 text-left">PIC</th><th class="px-4 py-2 text-center">Follow-up terakhir</th></tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                        @forelse($missingStatus as $t)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30">
                            <td class="px-4 py-2 font-medium text-gray-900 dark:text-white">{{ $t->arrearsItem->plate_number ?? '-' }}</td>
                            <td class="px-4 py-2 text-gray-600 dark:text-gray-300">{{ $t->employee->name ?? '-' }}</td>
                            <td class="px-4 py-2 text-center text-gray-500">{{ $t->latestFollowup?->followup_date?->format('d/m/Y') ?? '-' }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="3" class="px-4 py-8 text-center text-gray-400">Semua sudah diinput ✓</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Employee Workload --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm">
        <div class="px-5 py-4 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-sm font-semibold text-gray-800 dark:text-gray-200">Beban Kerja Pegawai</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 dark:bg-gray-700/50 text-xs text-gray-500 dark:text-gray-400 uppercase">
                    <tr><th class="px-4 py-2 text-left">Nama</th><th class="px-4 py-2 text-center">Tugas Aktif</th><th class="px-4 py-2 text-center">Follow-up (7 hari)</th></tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    @forelse($employeeWorkload as $emp)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30">
                        <td class="px-4 py-2 font-medium text-gray-900 dark:text-white">{{ $emp->name }}</td>
                        <td class="px-4 py-2 text-center">
                            <span class="px-2.5 py-0.5 rounded-full text-xs font-medium {{ $emp->active_tasks_count > 10 ? 'bg-red-100 text-red-700' : 'bg-blue-100 text-blue-700' }}">
                                {{ $emp->active_tasks_count }}
                            </span>
                        </td>
                        <td class="px-4 py-2 text-center text-gray-600 dark:text-gray-300">{{ $emp->followups_count }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="3" class="px-4 py-8 text-center text-gray-400">Belum ada data pegawai</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.7/dist/chart.umd.min.js"></script>
<script>
    // Status Distribution Chart
    const statusData = @json($statusDistribution);
    const statusLabels = {
        'dimiliki': 'Dimiliki', 'lapor_jual': 'Lapor Jual', 'rusak_berat': 'Rusak Berat',
        'hilang': 'Hilang', 'kecelakaan': 'Laka', 'alamat_tidak_jelas': 'Alamat Tdk Jelas',
        'pindah_alamat': 'Pindah Alamat', 'rumah_kosong': 'Rumah Kosong', 'lainnya': 'Lainnya'
    };
    const statusColors = ['#3b82f6','#6366f1','#f59e0b','#ef4444','#ec4899','#8b5cf6','#14b8a6','#f97316','#6b7280'];

    if (Object.keys(statusData).length > 0) {
        new Chart(document.getElementById('statusChart'), {
            type: 'doughnut',
            data: {
                labels: Object.keys(statusData).map(k => statusLabels[k] || k),
                datasets: [{
                    data: Object.values(statusData),
                    backgroundColor: statusColors.slice(0, Object.keys(statusData).length),
                    borderWidth: 0,
                    hoverOffset: 8
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { position: 'right', labels: { usePointStyle: true, pointStyle: 'circle', padding: 12, font: { size: 11 } } } }
            }
        });
    }

    // Follow-up Trend Chart
    const trendData = @json($followupTrend);
    const dates = [...new Set(trendData.map(d => d.date))].sort();
    const teleponData = dates.map(date => trendData.filter(d => d.date === date && d.type === 'telepon').reduce((s, d) => s + d.total, 0));
    const kunjunganData = dates.map(date => trendData.filter(d => d.date === date && d.type === 'kunjungan').reduce((s, d) => s + d.total, 0));

    if (dates.length > 0) {
        new Chart(document.getElementById('followupChart'), {
            type: 'bar',
            data: {
                labels: dates.map(d => { const dt = new Date(d); return dt.toLocaleDateString('id-ID', {day:'numeric', month:'short'}); }),
                datasets: [
                    { label: 'Telepon', data: teleponData, backgroundColor: '#3b82f6', borderRadius: 4 },
                    { label: 'Kunjungan', data: kunjunganData, backgroundColor: '#10b981', borderRadius: 4 }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } }, x: { grid: { display: false } } },
                plugins: { legend: { position: 'top', labels: { usePointStyle: true, pointStyle: 'circle', padding: 12, font: { size: 11 } } } }
            }
        });
    }
</script>
@endpush
</x-layouts.app>
