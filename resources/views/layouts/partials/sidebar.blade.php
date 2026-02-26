{{-- Sidebar --}}
<aside id="sidebar" class="fixed inset-y-0 left-0 z-40 w-64 bg-gradient-to-b from-slate-800 to-slate-900 text-white transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out flex flex-col">
    {{-- Brand --}}
    <div class="px-5 py-4 border-b border-slate-700/50">
        <div class="flex items-center space-x-3">
            <div class="w-9 h-9 rounded-lg bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center shadow-lg">
                <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 17V7m0 10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h2a2 2 0 012 2m0 10a2 2 0 002 2h2a2 2 0 002-2M9 7a2 2 0 012-2h2a2 2 0 012 2m0 10V7"/></svg>
            </div>
            <div>
                <h1 class="text-sm font-bold tracking-wide">SAMSAT</h1>
                <p class="text-[10px] text-slate-400 tracking-wider uppercase">Monitoring & Reminder</p>
            </div>
        </div>
    </div>

    {{-- Navigation --}}
    <nav class="flex-1 overflow-y-auto px-3 py-4 space-y-1">
        {{-- Dashboard --}}
        <a href="{{ route('dashboard') }}"
           class="flex items-center px-3 py-2.5 rounded-lg text-sm font-medium transition-all duration-200
                  {{ request()->routeIs('dashboard') ? 'bg-blue-600/20 text-blue-300 shadow-sm' : 'text-slate-300 hover:bg-slate-700/50 hover:text-white' }}">
            <svg class="w-5 h-5 mr-3 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z"/></svg>
            Dashboard
        </a>

        {{-- MONITORING PENAGIHAN --}}
        <div class="pt-4">
            <p class="px-3 text-[10px] font-semibold text-slate-500 uppercase tracking-widest mb-2">Monitoring Penagihan</p>
        </div>

        <a href="{{ route('monitoring.arrears.index') }}"
           class="flex items-center px-3 py-2.5 rounded-lg text-sm font-medium transition-all duration-200
                  {{ request()->routeIs('monitoring.arrears.*') ? 'bg-blue-600/20 text-blue-300 shadow-sm' : 'text-slate-300 hover:bg-slate-700/50 hover:text-white' }}">
            <svg class="w-5 h-5 mr-3 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0zm3 0h.008v.008H18V10.5zm-12 0h.008v.008H6V10.5z"/></svg>
            Tunggakan
        </a>

        <a href="{{ route('monitoring.tasks.index') }}"
           class="flex items-center px-3 py-2.5 rounded-lg text-sm font-medium transition-all duration-200
                  {{ request()->routeIs('monitoring.tasks.*') ? 'bg-blue-600/20 text-blue-300 shadow-sm' : 'text-slate-300 hover:bg-slate-700/50 hover:text-white' }}">
            <svg class="w-5 h-5 mr-3 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25z"/></svg>
            Tugas & Follow-up
        </a>

        <a href="{{ route('monitoring.kinerja.index') }}"
           class="flex items-center px-3 py-2.5 rounded-lg text-sm font-medium transition-all duration-200
                  {{ request()->routeIs('monitoring.kinerja.*') ? 'bg-blue-600/20 text-blue-300 shadow-sm' : 'text-slate-300 hover:bg-slate-700/50 hover:text-white' }}">
            <svg class="w-5 h-5 mr-3 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"/></svg>
            Kinerja Pegawai
        </a>

        <a href="{{ route('monitoring.spsopkb.index') }}"
           class="flex items-center px-3 py-2.5 rounded-lg text-sm font-medium transition-all duration-200
                  {{ request()->routeIs('monitoring.spsopkb.*') ? 'bg-blue-600/20 text-blue-300 shadow-sm' : 'text-slate-300 hover:bg-slate-700/50 hover:text-white' }}">
            <svg class="w-5 h-5 mr-3 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>
            SPSOPKB
        </a>

        {{-- REMINDER WHATSAPP --}}
        <div class="pt-4">
            <p class="px-3 text-[10px] font-semibold text-slate-500 uppercase tracking-widest mb-2">Reminder WhatsApp</p>
        </div>

        <a href="{{ route('reminder.taxpayers.index') }}"
           class="flex items-center px-3 py-2.5 rounded-lg text-sm font-medium transition-all duration-200
                  {{ request()->routeIs('reminder.taxpayers.*') ? 'bg-blue-600/20 text-blue-300 shadow-sm' : 'text-slate-300 hover:bg-slate-700/50 hover:text-white' }}">
            <svg class="w-5 h-5 mr-3 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 9h3.75M15 12h3.75M15 15h3.75M4.5 19.5h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5zm6-10.125a1.875 1.875 0 11-3.75 0 1.875 1.875 0 013.75 0zm1.294 6.336a6.721 6.721 0 01-3.17.789 6.721 6.721 0 01-3.168-.789 3.376 3.376 0 016.338 0z"/></svg>
            Kontak WP
        </a>

        <a href="{{ route('reminder.vehicles.index') }}"
           class="flex items-center px-3 py-2.5 rounded-lg text-sm font-medium transition-all duration-200
                  {{ request()->routeIs('reminder.vehicles.*') ? 'bg-blue-600/20 text-blue-300 shadow-sm' : 'text-slate-300 hover:bg-slate-700/50 hover:text-white' }}">
            <svg class="w-5 h-5 mr-3 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 01-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 00-3.213-9.193 2.056 2.056 0 00-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 00-10.026 0 1.106 1.106 0 00-.987 1.106v7.635m12-6.677v6.677m0 4.5v-4.5m0 0h-12"/></svg>
            Data Kendaraan
        </a>

        <a href="{{ route('reminder.batches.index') }}"
           class="flex items-center px-3 py-2.5 rounded-lg text-sm font-medium transition-all duration-200
                  {{ request()->routeIs('reminder.batches.*') ? 'bg-blue-600/20 text-blue-300 shadow-sm' : 'text-slate-300 hover:bg-slate-700/50 hover:text-white' }}">
            <svg class="w-5 h-5 mr-3 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5"/></svg>
            Batch Reminder
        </a>

        <a href="{{ route('reminder.logs.index') }}"
           class="flex items-center px-3 py-2.5 rounded-lg text-sm font-medium transition-all duration-200
                  {{ request()->routeIs('reminder.logs.*') ? 'bg-blue-600/20 text-blue-300 shadow-sm' : 'text-slate-300 hover:bg-slate-700/50 hover:text-white' }}">
            <svg class="w-5 h-5 mr-3 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 12h16.5m-16.5 3.75h16.5M3.75 19.5h16.5M5.625 4.5h12.75a1.875 1.875 0 010 3.75H5.625a1.875 1.875 0 010-3.75z"/></svg>
            Log Pesan
        </a>

        {{-- ADMIN --}}
        @if(auth()->user()->isAdmin())
        <div class="pt-4">
            <p class="px-3 text-[10px] font-semibold text-slate-500 uppercase tracking-widest mb-2">Administrasi</p>
        </div>

        <a href="{{ route('import.index') }}"
           class="flex items-center px-3 py-2.5 rounded-lg text-sm font-medium transition-all duration-200
                  {{ request()->routeIs('import.*') ? 'bg-blue-600/20 text-blue-300 shadow-sm' : 'text-slate-300 hover:bg-slate-700/50 hover:text-white' }}">
            <svg class="w-5 h-5 mr-3 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5"/></svg>
            Import Data
        </a>

        <a href="{{ route('admin.users.index') }}"
           class="flex items-center px-3 py-2.5 rounded-lg text-sm font-medium transition-all duration-200
                  {{ request()->routeIs('admin.users.*') ? 'bg-blue-600/20 text-blue-300 shadow-sm' : 'text-slate-300 hover:bg-slate-700/50 hover:text-white' }}">
            <svg class="w-5 h-5 mr-3 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6h9.75M10.5 6a1.5 1.5 0 11-3 0m3 0a1.5 1.5 0 10-3 0M3.75 6H7.5m3 12h9.75m-9.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-3.75 0H7.5m9-6h3.75m-3.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-9.75 0h9.75"/></svg>
            Kelola User
        </a>

        <a href="{{ route('reminder.rules.index') }}"
           class="flex items-center px-3 py-2.5 rounded-lg text-sm font-medium transition-all duration-200
                  {{ request()->routeIs('reminder.rules.*') ? 'bg-blue-600/20 text-blue-300 shadow-sm' : 'text-slate-300 hover:bg-slate-700/50 hover:text-white' }}">
            <svg class="w-5 h-5 mr-3 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 010 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.281z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            Aturan Reminder
        </a>
        @endif

        @if(auth()->user()->hasRole(['admin', 'operator']))
        @if(!auth()->user()->isAdmin())
        <div class="pt-4">
            <p class="px-3 text-[10px] font-semibold text-slate-500 uppercase tracking-widest mb-2">Tools</p>
        </div>
        <a href="{{ route('import.index') }}"
           class="flex items-center px-3 py-2.5 rounded-lg text-sm font-medium transition-all duration-200
                  {{ request()->routeIs('import.*') ? 'bg-blue-600/20 text-blue-300 shadow-sm' : 'text-slate-300 hover:bg-slate-700/50 hover:text-white' }}">
            <svg class="w-5 h-5 mr-3 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5"/></svg>
            Import Data
        </a>
        @endif
        @endif
    </nav>

    {{-- User section at bottom --}}
    <div class="border-t border-slate-700/50 p-4">
        <div class="flex items-center space-x-3">
            <div class="w-8 h-8 rounded-full bg-gradient-to-br from-blue-400 to-indigo-500 flex items-center justify-center text-xs font-bold text-white">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-sm font-medium text-white truncate">{{ auth()->user()->name }}</p>
                <p class="text-[10px] text-slate-400 uppercase">{{ auth()->user()->role }}</p>
            </div>
        </div>
    </div>
</aside>
