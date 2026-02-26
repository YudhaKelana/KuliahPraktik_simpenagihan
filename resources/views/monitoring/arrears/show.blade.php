<x-layouts.app :title="'Detail Tunggakan'">
    <div class="max-w-4xl mx-auto">
        <a href="{{ route('monitoring.arrears.index') }}" class="inline-flex items-center text-sm text-gray-500 hover:text-gray-700 mb-4">
            <svg class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"/></svg> Kembali
        </a>
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6 mb-6 shadow-sm">
            <h1 class="text-xl font-bold text-gray-900 dark:text-white mb-1">{{ $arrear->plate_number }}</h1>
            <p class="text-sm text-gray-500">{{ $arrear->owner_name ?? '-' }}</p>
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mt-4 text-sm">
                <div><span class="text-gray-500">HP</span><p class="font-medium text-gray-900 dark:text-white">{{ $arrear->masked_phone }}</p></div>
                <div><span class="text-gray-500">Alamat</span><p class="font-medium text-gray-900 dark:text-white">{{ $arrear->address ?? '-' }}</p></div>
                <div><span class="text-gray-500">Tunggakan</span><p class="font-medium text-red-600">Rp {{ number_format($arrear->arrears_amount, 0, ',', '.') }} ({{ $arrear->arrears_years }} thn)</p></div>
                <div><span class="text-gray-500">Kendaraan</span><p class="font-medium text-gray-900 dark:text-white">{{ $arrear->vehicle_brand ?? '-' }} {{ $arrear->vehicle_year ?? '' }}</p></div>
            </div>
            @if($arrear->flag_phone_invalid || $arrear->flag_address_suspect)
            <div class="mt-3 flex space-x-2">
                @if($arrear->flag_phone_invalid)<span class="px-2 py-0.5 text-xs rounded-full bg-red-100 text-red-700">HP Tidak Valid</span>@endif
                @if($arrear->flag_address_suspect)<span class="px-2 py-0.5 text-xs rounded-full bg-amber-100 text-amber-700">Alamat Rawan</span>@endif
            </div>
            @endif
        </div>

        {{-- Related Tasks --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm">
            <div class="px-5 py-4 border-b border-gray-200 dark:border-gray-700"><h3 class="text-sm font-semibold text-gray-800 dark:text-gray-200">Tugas Terkait</h3></div>
            <div class="divide-y divide-gray-100 dark:divide-gray-700">
                @forelse($arrear->tasks as $task)
                <div class="px-4 py-3">
                    <div class="flex items-center justify-between mb-1">
                        <a href="{{ route('monitoring.tasks.show', $task) }}" class="text-sm font-medium text-blue-600 hover:underline">Tugas #{{ $task->id }}</a>
                        <span class="px-2 py-0.5 text-xs rounded-full {{ $task->status === 'done' ? 'bg-emerald-100 text-emerald-700' : ($task->status === 'in_progress' ? 'bg-blue-100 text-blue-700' : 'bg-gray-100 text-gray-700') }}">{{ ucfirst(str_replace('_',' ',$task->status)) }}</span>
                    </div>
                    <p class="text-xs text-gray-500">PIC: {{ $task->employee->name ?? '-' }} &bull; {{ $task->followups->count() }} follow-up</p>
                </div>
                @empty
                <p class="px-4 py-8 text-center text-gray-400 text-sm">Belum ada tugas terkait</p>
                @endforelse
            </div>
        </div>
    </div>
</x-layouts.app>
