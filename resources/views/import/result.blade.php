<x-layouts.app :title="'Hasil Import'">
    <div class="max-w-3xl mx-auto">
        <a href="{{ route('import.index') }}" class="inline-flex items-center text-sm text-gray-500 hover:text-gray-700 mb-4">
            <svg class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"/></svg> Kembali
        </a>

        <h1 class="text-lg font-bold text-gray-900 dark:text-white mb-6">Hasil Import — {{ ucfirst($type) }}</h1>

        {{-- Summary --}}
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-6">
            <div class="bg-emerald-50 dark:bg-emerald-900/30 border border-emerald-200 dark:border-emerald-800 rounded-xl p-4 text-center">
                <p class="text-2xl font-bold text-emerald-700 dark:text-emerald-300">{{ $result['created'] }}</p>
                <p class="text-xs text-emerald-600">Dibuat</p>
            </div>
            <div class="bg-blue-50 dark:bg-blue-900/30 border border-blue-200 dark:border-blue-800 rounded-xl p-4 text-center">
                <p class="text-2xl font-bold text-blue-700 dark:text-blue-300">{{ $result['updated'] }}</p>
                <p class="text-xs text-blue-600">Diperbarui</p>
            </div>
            <div class="bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl p-4 text-center">
                <p class="text-2xl font-bold text-gray-700 dark:text-gray-300">{{ $result['skipped'] }}</p>
                <p class="text-xs text-gray-500">Dilewati</p>
            </div>
            <div class="bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-800 rounded-xl p-4 text-center">
                <p class="text-2xl font-bold text-red-700 dark:text-red-300">{{ count($result['errors']) }}</p>
                <p class="text-xs text-red-600">Error</p>
            </div>
        </div>

        {{-- Errors --}}
        @if(count($result['errors']) > 0)
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm">
            <div class="px-5 py-4 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-sm font-semibold text-red-600">Daftar Error</h3>
            </div>
            <div class="divide-y divide-gray-100 dark:divide-gray-700 max-h-96 overflow-y-auto">
                @foreach($result['errors'] as $err)
                <div class="px-4 py-2.5 text-sm">
                    <span class="font-medium text-gray-600 dark:text-gray-300">Baris {{ $err['row'] }}:</span>
                    <span class="text-red-600 dark:text-red-400">{{ $err['message'] }}</span>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</x-layouts.app>
