<x-layouts.app :title="'Edit Wajib Pajak'">
    {{-- Back --}}
    <div>
        <a href="{{ route('reminder.taxpayers.show', $taxpayer) }}" class="inline-flex items-center text-sm text-gray-500 hover:text-gray-700 mb-4">
            <svg class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
            Kembali ke Detail
        </a>
    </div>

    <div class="max-w-2xl">
        <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-6">Edit Data Wajib Pajak</h2>

        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm p-6">
            <form method="POST" action="{{ route('reminder.taxpayers.update', $taxpayer) }}" class="space-y-4">
                @csrf
                @method('PUT')

                {{-- Nama --}}
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nama</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $taxpayer->name) }}" required
                           class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm">
                    @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                {{-- Phone --}}
                <div>
                    <label for="phone_e164" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">No. Telepon (E.164)</label>
                    <input type="text" name="phone_e164" id="phone_e164" value="{{ old('phone_e164', $taxpayer->phone_e164) }}" placeholder="+6281234567890"
                           class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm">
                    @error('phone_e164')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                {{-- Alamat --}}
                <div>
                    <label for="address" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Alamat</label>
                    <textarea name="address" id="address" rows="3"
                              class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm">{{ old('address', $taxpayer->address) }}</textarea>
                    @error('address')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                {{-- Actions --}}
                <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-200 dark:border-gray-700">
                    <a href="{{ route('reminder.taxpayers.show', $taxpayer) }}" class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 hover:text-gray-900 transition">Batal</a>
                    <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-gradient-to-r from-blue-600 to-indigo-600 rounded-lg hover:from-blue-500 hover:to-indigo-500 shadow-sm transition">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.app>
