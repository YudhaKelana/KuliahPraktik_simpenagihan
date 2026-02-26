<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Samsat Monitoring' }} — Samsat TPI</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full bg-gray-50 dark:bg-gray-900">
    <div class="min-h-full flex">
        {{-- Sidebar --}}
        @include('layouts.partials.sidebar')

        {{-- Main Content --}}
        <div class="flex-1 flex flex-col min-h-screen lg:ml-64">
            {{-- Topbar --}}
            @include('layouts.partials.topbar')

            {{-- Page Content --}}
            <main class="flex-1 p-4 lg:p-6">
                {{-- Flash Messages --}}
                @if(session('success'))
                    <div class="mb-4 p-4 rounded-lg bg-emerald-50 dark:bg-emerald-900/30 border border-emerald-200 dark:border-emerald-800 text-emerald-700 dark:text-emerald-300" id="flash-success">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-2 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                            {{ session('success') }}
                        </div>
                    </div>
                @endif
                @if(session('error'))
                    <div class="mb-4 p-4 rounded-lg bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-800 text-red-700 dark:text-red-300" id="flash-error">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-2 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                            {{ session('error') }}
                        </div>
                    </div>
                @endif

                {{ $slot }}
            </main>

            {{-- Footer --}}
            <footer class="border-t border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 px-6 py-3 text-center text-xs text-gray-500 dark:text-gray-400">
                &copy; {{ date('Y') }} UPTD PPD Samsat Kota Tanjungpinang — Seksi Penagihan
            </footer>
        </div>
    </div>

    {{-- Mobile sidebar overlay --}}
    <div id="sidebar-overlay" class="fixed inset-0 bg-black/50 z-30 hidden lg:hidden" onclick="toggleSidebar()"></div>

    @stack('scripts')
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebar-overlay');
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        }

        // Auto-hide flash messages
        setTimeout(() => {
            document.querySelectorAll('#flash-success, #flash-error').forEach(el => {
                el.style.transition = 'opacity 0.5s';
                el.style.opacity = '0';
                setTimeout(() => el.remove(), 500);
            });
        }, 4000);
    </script>
</body>
</html>
