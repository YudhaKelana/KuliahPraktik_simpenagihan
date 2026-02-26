<x-layouts.app :title="'Import Data'">
    <div class="max-w-3xl mx-auto">
        <h1 class="text-lg font-bold text-gray-900 dark:text-white mb-6">Import Data</h1>

        {{-- Templates --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-5 mb-6 shadow-sm">
            <h3 class="text-sm font-semibold text-gray-800 dark:text-gray-200 mb-3">Download Template</h3>
            <div class="grid grid-cols-2 sm:grid-cols-3 gap-2">
                @foreach(['arrears' => 'Tunggakan', 'tasks' => 'Tugas', 'followups' => 'Follow-up', 'vehicle_statuses' => 'Status Kendaraan', 'taxpayers' => 'Wajib Pajak', 'vehicles' => 'Kendaraan'] as $key => $label)
                <a href="{{ route('import.template', $key) }}" class="flex items-center px-3 py-2 rounded-lg bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 text-sm text-gray-700 dark:text-gray-300 hover:bg-blue-50 dark:hover:bg-blue-900/20 hover:border-blue-300 transition">
                    <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3"/></svg>
                    {{ $label }}
                </a>
                @endforeach
            </div>
        </div>

        {{-- Upload Form --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6 shadow-sm">
            <h3 class="text-sm font-semibold text-gray-800 dark:text-gray-200 mb-4">Upload File</h3>
            <form method="POST" action="{{ route('import.upload') }}" enctype="multipart/form-data" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Jenis Data</label>
                    <select name="type" required class="w-full rounded-lg border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-sm dark:text-white">
                        <option value="">-- Pilih jenis --</option>
                        <option value="arrears">Tunggakan</option>
                        <option value="tasks">Tugas</option>
                        <option value="followups">Follow-up</option>
                        <option value="vehicle_statuses">Status Kendaraan</option>
                        <option value="taxpayers">Wajib Pajak</option>
                        <option value="vehicles">Kendaraan (Reminder)</option>
                    </select>
                    @error('type')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">File (CSV / Excel)</label>
                    <input type="file" name="file" accept=".csv,.xlsx,.xls,.txt" required class="w-full text-sm text-gray-600 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 dark:file:bg-blue-900/30 dark:file:text-blue-400">
                    @error('file')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                </div>
                <button type="submit" class="w-full py-2.5 rounded-lg bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-medium text-sm hover:from-blue-500 hover:to-indigo-500 transition shadow-sm">
                    Upload & Import
                </button>
            </form>
        </div>
    </div>
</x-layouts.app>
