<x-layouts.app :title="'Kelola User'">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-lg font-bold text-gray-900 dark:text-white">Kelola User</h1>
        <a href="{{ route('admin.users.create') }}" class="inline-flex items-center px-4 py-2 rounded-lg bg-gradient-to-r from-blue-600 to-indigo-600 text-white text-sm font-medium hover:from-blue-500 hover:to-indigo-500 transition shadow-sm">
            <svg class="w-4 h-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
            Tambah User
        </a>
    </div>
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 dark:bg-gray-700/50 text-xs text-gray-500 uppercase"><tr><th class="px-4 py-3 text-left">Nama</th><th class="px-4 py-3 text-left">Email</th><th class="px-4 py-3 text-center">Role</th><th class="px-4 py-3 text-center">Status</th><th class="px-4 py-3 text-center">Aksi</th></tr></thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    @foreach($users as $user)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30">
                        <td class="px-4 py-3 font-medium text-gray-900 dark:text-white">{{ $user->name }}</td>
                        <td class="px-4 py-3 text-gray-500">{{ $user->email }}</td>
                        <td class="px-4 py-3 text-center"><span class="px-2 py-0.5 text-xs rounded-full font-medium {{ $user->role === 'admin' ? 'bg-purple-100 text-purple-700' : ($user->role === 'supervisor' ? 'bg-blue-100 text-blue-700' : 'bg-green-100 text-green-700') }}">{{ ucfirst($user->role) }}</span></td>
                        <td class="px-4 py-3 text-center"><span class="px-2 py-0.5 text-xs rounded-full {{ $user->is_active ? 'bg-emerald-100 text-emerald-700' : 'bg-red-100 text-red-700' }}">{{ $user->is_active ? 'Aktif' : 'Nonaktif' }}</span></td>
                        <td class="px-4 py-3 text-center"><a href="{{ route('admin.users.edit', $user) }}" class="text-xs text-blue-600 hover:underline">Edit</a></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="px-4 py-3 border-t border-gray-100 dark:border-gray-700">{{ $users->links() }}</div>
    </div>
</x-layouts.app>
