<x-layouts.app :title="'Edit Tugas #' . $task->id">
    <div class="max-w-2xl mx-auto">
        <a href="{{ route('monitoring.tasks.show', $task) }}" class="inline-flex items-center text-sm text-gray-500 hover:text-gray-700 mb-4">
            <svg class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"/></svg> Kembali
        </a>
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6 shadow-sm">
            <h1 class="text-lg font-bold text-gray-900 dark:text-white mb-6">Edit Tugas #{{ $task->id }}</h1>
            <form method="POST" action="{{ route('monitoring.tasks.update', $task) }}" class="space-y-4">
                @csrf @method('PUT')
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">PIC / Pegawai</label>
                    <select name="employee_id" class="w-full rounded-lg border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-sm dark:text-white">
                        <option value="">-- Belum ditentukan --</option>
                        @foreach($employees as $emp)
                            <option value="{{ $emp->id }}" {{ $task->employee_id == $emp->id ? 'selected' : '' }}>{{ $emp->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Status</label>
                    <select name="status" required class="w-full rounded-lg border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-sm dark:text-white">
                        <option value="new" {{ $task->status === 'new' ? 'selected' : '' }}>Baru</option>
                        <option value="in_progress" {{ $task->status === 'in_progress' ? 'selected' : '' }}>Dalam Proses</option>
                        <option value="done" {{ $task->status === 'done' ? 'selected' : '' }}>Selesai</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Batas Waktu</label>
                    <input type="date" name="due_date" value="{{ $task->due_date?->format('Y-m-d') }}" class="w-full rounded-lg border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-sm dark:text-white">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Catatan</label>
                    <textarea name="notes" rows="3" class="w-full rounded-lg border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-sm dark:text-white">{{ $task->notes }}</textarea>
                </div>
                <button type="submit" class="w-full py-2.5 rounded-lg bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-medium text-sm hover:from-blue-500 hover:to-indigo-500 transition shadow-sm">Perbarui Tugas</button>
            </form>
        </div>
    </div>
</x-layouts.app>
