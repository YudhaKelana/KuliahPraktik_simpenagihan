<x-layouts.app :title="'Buat Tugas Baru'">
    <div class="max-w-2xl mx-auto">
        <a href="{{ route('monitoring.tasks.index') }}" class="inline-flex items-center text-sm text-gray-500 hover:text-gray-700 mb-4">
            <svg class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"/></svg> Kembali
        </a>
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6 shadow-sm">
            <h1 class="text-lg font-bold text-gray-900 dark:text-white mb-6">Buat Tugas Baru</h1>
            <form method="POST" action="{{ route('monitoring.tasks.store') }}" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Data Tunggakan</label>
                    <select name="arrears_item_id" required class="w-full rounded-lg border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-sm dark:text-white">
                        <option value="">-- Pilih kendaraan --</option>
                        @foreach($arrearsItems as $item)
                            <option value="{{ $item->id }}">{{ $item->plate_number }} — {{ $item->owner_name ?? 'N/A' }}</option>
                        @endforeach
                    </select>
                    @error('arrears_item_id')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">PIC / Pegawai</label>
                    <select name="employee_id" class="w-full rounded-lg border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-sm dark:text-white">
                        <option value="">-- Belum ditentukan --</option>
                        @foreach($employees as $emp)
                            <option value="{{ $emp->id }}">{{ $emp->name }} ({{ $emp->jabatan ?? '-' }})</option>
                        @endforeach
                    </select>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tanggal Tugas</label>
                        <input type="date" name="assigned_date" value="{{ date('Y-m-d') }}" required class="w-full rounded-lg border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-sm dark:text-white">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Batas Waktu</label>
                        <input type="date" name="due_date" class="w-full rounded-lg border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-sm dark:text-white">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Catatan</label>
                    <textarea name="notes" rows="3" class="w-full rounded-lg border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-sm dark:text-white"></textarea>
                </div>
                <button type="submit" class="w-full py-2.5 rounded-lg bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-medium text-sm hover:from-blue-500 hover:to-indigo-500 transition shadow-sm">Simpan Tugas</button>
            </form>
        </div>
    </div>
</x-layouts.app>
