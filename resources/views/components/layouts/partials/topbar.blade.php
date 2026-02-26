{{-- Topbar --}}
<header class="sticky top-0 z-20 bg-white/80 dark:bg-gray-800/80 backdrop-blur-md border-b border-gray-200 dark:border-gray-700">
    <div class="flex items-center justify-between h-14 px-4 lg:px-6">
        {{-- Mobile menu button --}}
        <button onclick="toggleSidebar()" class="lg:hidden p-2 rounded-lg text-gray-500 hover:bg-gray-100 dark:hover:bg-gray-700 transition">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"/></svg>
        </button>

        {{-- Page title --}}
        <h2 class="text-base font-semibold text-gray-800 dark:text-gray-200 hidden lg:block">
            {{ $title ?? 'Dashboard' }}
        </h2>

        {{-- Right side --}}
        <div class="flex items-center space-x-3">
            {{-- Clock --}}
            <span class="text-xs text-gray-500 dark:text-gray-400 hidden sm:block" id="live-clock"></span>

            {{-- Logout --}}
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="flex items-center space-x-1.5 px-3 py-1.5 rounded-lg text-sm text-gray-600 dark:text-gray-300 hover:bg-red-50 dark:hover:bg-red-900/20 hover:text-red-600 dark:hover:text-red-400 transition">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9"/></svg>
                    <span class="hidden sm:inline">Keluar</span>
                </button>
            </form>
        </div>
    </div>
</header>

@push('scripts')
<script>
    function updateClock() {
        const now = new Date();
        const options = { timeZone: 'Asia/Jakarta', hour: '2-digit', minute: '2-digit', second: '2-digit', hour12: false };
        const dateOptions = { timeZone: 'Asia/Jakarta', weekday: 'short', day: 'numeric', month: 'short', year: 'numeric' };
        const timeStr = now.toLocaleTimeString('id-ID', options);
        const dateStr = now.toLocaleDateString('id-ID', dateOptions);
        const el = document.getElementById('live-clock');
        if (el) el.textContent = dateStr + ' • ' + timeStr;
    }
    updateClock();
    setInterval(updateClock, 1000);
</script>
@endpush
