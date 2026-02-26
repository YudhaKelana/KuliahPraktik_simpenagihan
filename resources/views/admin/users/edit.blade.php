<x-layouts.app :title="'Edit User'">
    <div class="max-w-2xl mx-auto">
        <a href="{{ route('admin.users.index') }}" class="inline-flex items-center text-sm text-gray-500 hover:text-gray-700 mb-4"><svg class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"/></svg> Kembali</a>
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6 shadow-sm">
            <h1 class="text-lg font-bold text-gray-900 dark:text-white mb-6">Edit User — {{ $user->name }}</h1>
            <form method="POST" action="{{ route('admin.users.update', $user) }}" class="space-y-4">@csrf @method('PUT')
                <div><label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nama</label><input type="text" name="name" value="{{ $user->name }}" required class="w-full rounded-lg border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-sm dark:text-white"></div>
                <div><label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Email</label><input type="email" name="email" value="{{ $user->email }}" required class="w-full rounded-lg border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-sm dark:text-white"></div>
                <div><label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Role</label><select name="role" required class="w-full rounded-lg border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-sm dark:text-white"><option value="operator" {{ $user->role === 'operator' ? 'selected' : '' }}>Operator</option><option value="supervisor" {{ $user->role === 'supervisor' ? 'selected' : '' }}>Supervisor</option><option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option></select></div>
                <div class="flex items-center"><input type="checkbox" name="is_active" value="1" {{ $user->is_active ? 'checked' : '' }} class="w-4 h-4 rounded"><label class="ml-2 text-sm text-gray-700 dark:text-gray-300">Aktif</label></div>
                <div><label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Password Baru (kosongkan jika tidak ubah)</label><input type="password" name="password" class="w-full rounded-lg border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-sm dark:text-white"></div>
                <div><label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Konfirmasi Password</label><input type="password" name="password_confirmation" class="w-full rounded-lg border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-sm dark:text-white"></div>
                <button type="submit" class="w-full py-2.5 rounded-lg bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-medium text-sm hover:from-blue-500 hover:to-indigo-500 transition shadow-sm">Perbarui</button>
            </form>
        </div>
    </div>
</x-layouts.app>
