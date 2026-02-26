<x-layouts.app :title="'Tambah User'">
    <div class="max-w-2xl mx-auto">
        <a href="{{ route('admin.users.index') }}" class="inline-flex items-center text-sm text-gray-500 hover:text-gray-700 mb-4"><svg class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"/></svg> Kembali</a>
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6 shadow-sm">
            <h1 class="text-lg font-bold text-gray-900 dark:text-white mb-6">Tambah User</h1>
            <form method="POST" action="{{ route('admin.users.store') }}" class="space-y-4">@csrf
                <div><label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nama</label><input type="text" name="name" value="{{ old('name') }}" required class="w-full rounded-lg border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-sm dark:text-white">@error('name')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror</div>
                <div><label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Email</label><input type="email" name="email" value="{{ old('email') }}" required class="w-full rounded-lg border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-sm dark:text-white">@error('email')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror</div>
                <div><label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Role</label><select name="role" required class="w-full rounded-lg border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-sm dark:text-white"><option value="operator">Operator</option><option value="supervisor">Supervisor</option><option value="admin">Admin</option></select></div>
                <div><label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Password</label><input type="password" name="password" required class="w-full rounded-lg border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-sm dark:text-white">@error('password')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror</div>
                <div><label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Konfirmasi Password</label><input type="password" name="password_confirmation" required class="w-full rounded-lg border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-sm dark:text-white"></div>
                <button type="submit" class="w-full py-2.5 rounded-lg bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-medium text-sm hover:from-blue-500 hover:to-indigo-500 transition shadow-sm">Simpan</button>
            </form>
        </div>
    </div>
</x-layouts.app>
