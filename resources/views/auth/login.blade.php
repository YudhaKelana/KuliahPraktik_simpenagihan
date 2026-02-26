<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — Samsat Monitoring</title>
    @vite(['resources/css/app.css'])
</head>
<body class="h-full bg-gradient-to-br from-slate-900 via-blue-950 to-indigo-950 flex items-center justify-center p-4">
    {{-- Decorative blobs --}}
    <div class="absolute top-0 left-0 w-96 h-96 bg-blue-500/10 rounded-full blur-3xl -translate-x-1/2 -translate-y-1/2"></div>
    <div class="absolute bottom-0 right-0 w-96 h-96 bg-indigo-500/10 rounded-full blur-3xl translate-x-1/2 translate-y-1/2"></div>

    <div class="relative w-full max-w-md">
        {{-- Card --}}
        <div class="bg-white/5 backdrop-blur-xl border border-white/10 rounded-2xl shadow-2xl p-8">
            {{-- Header --}}
            <div class="text-center mb-8">
                <div class="w-16 h-16 mx-auto rounded-2xl bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center shadow-lg shadow-blue-500/25 mb-4">
                    <svg class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 17V7m0 10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h2a2 2 0 012 2m0 10a2 2 0 002 2h2a2 2 0 002-2M9 7a2 2 0 012-2h2a2 2 0 012 2m0 10V7"/></svg>
                </div>
                <h1 class="text-xl font-bold text-white mb-1">Samsat Monitoring</h1>
                <p class="text-sm text-slate-400">UPTD PPD Samsat Kota Tanjungpinang</p>
            </div>

            {{-- Error --}}
            @if(session('error'))
                <div class="mb-4 p-3 rounded-lg bg-red-500/10 border border-red-500/20 text-red-300 text-sm">
                    {{ session('error') }}
                </div>
            @endif
            @if($errors->any())
                <div class="mb-4 p-3 rounded-lg bg-red-500/10 border border-red-500/20 text-red-300 text-sm">
                    {{ $errors->first() }}
                </div>
            @endif

            {{-- Form --}}
            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                <div>
                    <label for="email" class="block text-sm font-medium text-slate-300 mb-1.5">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus
                           class="w-full px-4 py-2.5 rounded-xl bg-white/5 border border-white/10 text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500/50 transition"
                           placeholder="nama@samsat.go.id">
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-slate-300 mb-1.5">Password</label>
                    <input type="password" id="password" name="password" required
                           class="w-full px-4 py-2.5 rounded-xl bg-white/5 border border-white/10 text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500/50 transition"
                           placeholder="••••••••">
                </div>

                <div class="flex items-center">
                    <input type="checkbox" id="remember" name="remember" class="w-4 h-4 rounded border-white/10 bg-white/5 text-blue-500 focus:ring-blue-500/50">
                    <label for="remember" class="ml-2 text-sm text-slate-400">Ingat saya</label>
                </div>

                <button type="submit"
                        class="w-full py-2.5 px-4 rounded-xl bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-semibold text-sm hover:from-blue-500 hover:to-indigo-500 focus:outline-none focus:ring-2 focus:ring-blue-500/50 transition shadow-lg shadow-blue-500/25">
                    Masuk
                </button>
            </form>
        </div>

        {{-- Footer --}}
        <p class="text-center text-xs text-slate-500 mt-6">Seksi Penagihan &bull; {{ date('Y') }}</p>
    </div>
</body>
</html>
