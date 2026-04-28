<x-layouts.app :title="'Edit Wajib Pajak'">
    <div class="max-w-2xl mx-auto">
        <a href="{{ route('reminder.taxpayers.index') }}" class="inline-flex items-center text-sm text-gray-500 hover:text-gray-700 dark:hover:text-gray-300 mb-4">
            <svg class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"/></svg> Kembali
        </a>

        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6 shadow-sm">
            <div class="flex items-center space-x-3 mb-6">
                <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-emerald-500 to-teal-600 flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/></svg>
                </div>
                <div>
                    <h1 class="text-lg font-bold text-gray-900 dark:text-white">Edit Wajib Pajak</h1>
                    <p class="text-xs text-gray-500">{{ $taxpayer->name }} — {{ $taxpayer->nik ?? 'NIK belum diisi' }}</p>
                </div>
            </div>

            @if(session('success'))
                <div class="mb-4 p-3 rounded-lg bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-800 text-sm text-emerald-700 dark:text-emerald-300">
                    {{ session('success') }}
                </div>
            @endif

            <form method="POST" action="{{ route('reminder.taxpayers.update', $taxpayer) }}" class="space-y-4">
                @csrf @method('PUT')

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nama <span class="text-red-500">*</span></label>
                    <input type="text" name="name" value="{{ old('name', $taxpayer->name) }}" required
                           class="w-full rounded-lg border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-sm dark:text-white focus:ring-blue-500 focus:border-blue-500"
                           placeholder="Nama wajib pajak">
                    @error('name')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">NIK</label>
                        <input type="text" value="{{ $taxpayer->nik ?? '-' }}" disabled
                               class="w-full rounded-lg border-gray-300 dark:border-gray-600 bg-gray-100 dark:bg-gray-600 text-sm text-gray-500 dark:text-gray-400 cursor-not-allowed">
                        <p class="text-xs text-gray-400 mt-1">NIK tidak dapat diubah</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Email</label>
                        <input type="text" value="{{ $taxpayer->email ?? '-' }}" disabled
                               class="w-full rounded-lg border-gray-300 dark:border-gray-600 bg-gray-100 dark:bg-gray-600 text-sm text-gray-500 dark:text-gray-400 cursor-not-allowed">
                        <p class="text-xs text-gray-400 mt-1">Email tidak dapat diubah dari sini</p>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">No. Telepon (E.164)</label>
                    <input type="text" name="phone_e164" value="{{ old('phone_e164', $taxpayer->phone_e164) }}"
                           class="w-full rounded-lg border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-sm dark:text-white focus:ring-blue-500 focus:border-blue-500"
                           placeholder="+6281234567890">
                    @error('phone_e164')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Alamat</label>
                    <textarea name="address" rows="3"
                              class="w-full rounded-lg border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-sm dark:text-white focus:ring-blue-500 focus:border-blue-500"
                              placeholder="Alamat lengkap wajib pajak">{{ old('address', $taxpayer->address) }}</textarea>
                    @error('address')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                </div>

                {{-- Info read-only --}}
                <div class="p-3 rounded-lg bg-gray-50 dark:bg-gray-700/50 border border-gray-200 dark:border-gray-600">
                    <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide mb-2">Informasi Lainnya</p>
                    <div class="grid grid-cols-3 gap-3 text-sm">
                        <div>
                            <span class="text-gray-400 dark:text-gray-500 text-xs">Kecamatan</span>
                            <p class="text-gray-700 dark:text-gray-300">{{ $taxpayer->district ?? '-' }}</p>
                        </div>
                        <div>
                            <span class="text-gray-400 dark:text-gray-500 text-xs">Kelurahan</span>
                            <p class="text-gray-700 dark:text-gray-300">{{ $taxpayer->sub_district ?? '-' }}</p>
                        </div>
                        <div>
                            <span class="text-gray-400 dark:text-gray-500 text-xs">Kode Pos</span>
                            <p class="text-gray-700 dark:text-gray-300">{{ $taxpayer->postal_code ?? '-' }}</p>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-3 mt-2 text-sm">
                        <div>
                            <span class="text-gray-400 dark:text-gray-500 text-xs">Status Opt-Out</span>
                            <p>
                                @if($taxpayer->opt_out)
                                    <span class="px-2 py-0.5 text-xs rounded-full bg-red-100 text-red-700">Opt-Out</span>
                                    <span class="text-xs text-gray-400 dark:text-gray-500 ml-1">{{ $taxpayer->opt_out_at?->format('d/m/Y H:i') }}</span>
                                @else
                                    <span class="px-2 py-0.5 text-xs rounded-full bg-emerald-100 text-emerald-700">Aktif</span>
                                @endif
                            </p>
                        </div>
                        <div>
                            <span class="text-gray-400 dark:text-gray-500 text-xs">Jumlah Kendaraan</span>
                            <p class="text-gray-700 dark:text-gray-300 font-medium">{{ $taxpayer->vehicles()->count() }}</p>
                        </div>
                    </div>
                </div>

                <button type="submit" class="w-full py-2.5 rounded-lg bg-gradient-to-r from-emerald-600 to-teal-600 text-white font-medium text-sm hover:from-emerald-500 hover:to-teal-500 transition shadow-sm">
                    Perbarui Data Wajib Pajak
                </button>
            </form>
        </div>
    </div>
</x-layouts.app>
