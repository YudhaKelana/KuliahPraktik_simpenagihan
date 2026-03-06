<x-layouts.app :title="'Tambah User'">
    <div class="max-w-2xl mx-auto">
        <a href="{{ route('admin.users.index') }}" class="inline-flex items-center text-sm text-gray-500 hover:text-gray-700 mb-4">
            <svg class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"/></svg> Kembali
        </a>

        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6 shadow-sm">
            <div class="flex items-center space-x-3 mb-6">
                <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zM4 19.235v-.11a6.375 6.375 0 0112.75 0v.109A12.318 12.318 0 0110.374 21c-2.331 0-4.512-.645-6.374-1.766z"/></svg>
                </div>
                <div>
                    <h1 class="text-lg font-bold text-gray-900 dark:text-white">Tambah User</h1>
                    <p class="text-xs text-gray-500">Buat akun pengguna baru untuk sistem</p>
                </div>
            </div>

            {{-- Role preview --}}
            <div id="role-preview" class="mb-4 p-4 rounded-lg bg-gray-50 dark:bg-gray-700/50 border border-gray-200 dark:border-gray-600 transition-all duration-300">
                <div class="flex items-center space-x-3">
                    <div id="role-icon" class="w-8 h-8 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center text-sm font-bold">P</div>
                    <div>
                        <p class="text-sm font-medium text-gray-900 dark:text-white" id="role-name">Petugas Penagihan</p>
                        <p class="text-xs text-gray-500" id="role-desc">Akses monitoring & reminder, tanpa administrasi</p>
                    </div>
                </div>
            </div>

            <form method="POST" action="{{ route('admin.users.store') }}" class="space-y-4" id="user-form">
                @csrf

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nama <span class="text-red-500">*</span></label>
                    <input type="text" name="name" id="name-input" value="{{ old('name') }}" required
                           class="w-full rounded-lg border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-sm dark:text-white focus:ring-blue-500 focus:border-blue-500"
                           placeholder="Nama lengkap pengguna">
                    @error('name')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Email <span class="text-red-500">*</span></label>
                    <input type="email" name="email" id="email-input" value="{{ old('email') }}" required
                           class="w-full rounded-lg border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-sm dark:text-white focus:ring-blue-500 focus:border-blue-500"
                           placeholder="email@samsat.go.id">
                    <p class="text-xs text-red-500 mt-1 hidden" id="email-error">Format email tidak valid</p>
                    @error('email')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Role <span class="text-red-500">*</span></label>
                    <select name="role" required id="role-select" class="w-full rounded-lg border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-sm dark:text-white">
                        <option value="petugas_penagihan" {{ old('role') === 'petugas_penagihan' ? 'selected' : '' }}>Petugas Penagihan</option>
                        <option value="koordinator_penagihan" {{ old('role') === 'koordinator_penagihan' ? 'selected' : '' }}>Koordinator Penagihan</option>
                        <option value="administrator_sistem" {{ old('role') === 'administrator_sistem' ? 'selected' : '' }}>Administrator Sistem</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Password <span class="text-red-500">*</span> <span class="text-gray-400 font-normal">(minimal 8 karakter)</span></label>
                    <div class="relative">
                        <input type="password" name="password" id="password-input" required minlength="8"
                               class="w-full rounded-lg border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-sm dark:text-white pr-10 focus:ring-blue-500 focus:border-blue-500"
                               placeholder="••••••••">
                        <button type="button" id="toggle-pw" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 transition">
                            <svg class="w-4 h-4" id="eye-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        </button>
                    </div>
                    {{-- Password strength meter --}}
                    <div class="mt-2">
                        <div class="flex space-x-1 mb-1">
                            <div class="h-1 flex-1 rounded-full bg-gray-200 transition-all duration-300" id="pw-bar-1"></div>
                            <div class="h-1 flex-1 rounded-full bg-gray-200 transition-all duration-300" id="pw-bar-2"></div>
                            <div class="h-1 flex-1 rounded-full bg-gray-200 transition-all duration-300" id="pw-bar-3"></div>
                            <div class="h-1 flex-1 rounded-full bg-gray-200 transition-all duration-300" id="pw-bar-4"></div>
                        </div>
                        <p class="text-xs text-gray-400" id="pw-strength-text"></p>
                    </div>
                    @error('password')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Konfirmasi Password <span class="text-red-500">*</span></label>
                    <input type="password" name="password_confirmation" id="password-confirm" required
                           class="w-full rounded-lg border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-sm dark:text-white focus:ring-blue-500 focus:border-blue-500"
                           placeholder="••••••••">
                    <p class="text-xs mt-1 hidden" id="pw-match">
                        <span class="text-emerald-600">✓ Password cocok</span>
                    </p>
                    <p class="text-xs mt-1 hidden" id="pw-mismatch">
                        <span class="text-red-500">✗ Password tidak cocok</span>
                    </p>
                </div>

                <button type="submit" id="submit-btn" class="w-full py-2.5 rounded-lg bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-medium text-sm hover:from-blue-500 hover:to-indigo-500 transition shadow-sm disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center space-x-2">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                    <span>Simpan</span>
                </button>
            </form>
        </div>
    </div>

@push('scripts')
<script>
(function() {
    const roleSelect = document.getElementById('role-select');
    const rolePreview = document.getElementById('role-preview');
    const passwordInput = document.getElementById('password-input');
    const confirmInput = document.getElementById('password-confirm');
    const emailInput = document.getElementById('email-input');

    // Role info mapping
    const roles = {
        petugas_penagihan: { icon: 'P', color: 'bg-emerald-100 text-emerald-600', name: 'Petugas Penagihan', desc: 'Akses monitoring & reminder, tanpa administrasi' },
        koordinator_penagihan: { icon: 'K', color: 'bg-amber-100 text-amber-600', name: 'Koordinator Penagihan', desc: 'Monitoring + kinerja pegawai, approve batch, tanpa kelola user' },
        administrator_sistem: { icon: 'A', color: 'bg-red-100 text-red-600', name: 'Administrator Sistem', desc: 'Akses penuh ke seluruh fitur termasuk kelola user & aturan' }
    };

    roleSelect.addEventListener('change', function() {
        const r = roles[this.value];
        if (r) {
            document.getElementById('role-icon').className = `w-8 h-8 rounded-full ${r.color} flex items-center justify-center text-sm font-bold transition-all duration-300`;
            document.getElementById('role-icon').textContent = r.icon;
            document.getElementById('role-name').textContent = r.name;
            document.getElementById('role-desc').textContent = r.desc;
        }
    });

    // Email validation
    emailInput.addEventListener('input', function() {
        const error = document.getElementById('email-error');
        if (this.value && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(this.value)) {
            error.classList.remove('hidden');
        } else {
            error.classList.add('hidden');
        }
    });

    // Password toggle
    document.getElementById('toggle-pw').addEventListener('click', function() {
        const type = passwordInput.type === 'password' ? 'text' : 'password';
        passwordInput.type = type;
        confirmInput.type = type;
    });

    // Strength meter
    passwordInput.addEventListener('input', function() {
        const pw = this.value;
        let strength = 0;
        if (pw.length >= 8) strength++;
        if (/[a-z]/.test(pw) && /[A-Z]/.test(pw)) strength++;
        if (/\d/.test(pw)) strength++;
        if (/[^a-zA-Z0-9]/.test(pw)) strength++;

        const colors = ['bg-gray-200', 'bg-red-500', 'bg-amber-500', 'bg-blue-500', 'bg-emerald-500'];
        const labels = ['', 'Lemah', 'Cukup', 'Kuat', 'Sangat Kuat'];
        for (let i = 1; i <= 4; i++) {
            const bar = document.getElementById('pw-bar-' + i);
            bar.className = `h-1 flex-1 rounded-full transition-all duration-300 ${i <= strength ? colors[strength] : 'bg-gray-200'}`;
        }
        document.getElementById('pw-strength-text').textContent = pw ? labels[strength] : '';
        checkMatch();
    });

    // Confirm match
    function checkMatch() {
        const match = document.getElementById('pw-match');
        const mismatch = document.getElementById('pw-mismatch');
        if (!confirmInput.value) { match.classList.add('hidden'); mismatch.classList.add('hidden'); return; }
        if (passwordInput.value === confirmInput.value) {
            match.classList.remove('hidden'); mismatch.classList.add('hidden');
        } else {
            match.classList.add('hidden'); mismatch.classList.remove('hidden');
        }
    }
    confirmInput.addEventListener('input', checkMatch);

    // Submit loading
    document.getElementById('user-form').addEventListener('submit', function() {
        const btn = document.getElementById('submit-btn');
        btn.disabled = true;
        btn.innerHTML = '<svg class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg><span>Menyimpan...</span>';
    });
})();
</script>
@endpush
</x-layouts.app>
