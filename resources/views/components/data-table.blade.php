@props([
    'paginator' => null,
    'id' => 'data-table-' . uniqid(),
])

<div id="{{ $id }}" class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm overflow-hidden">
    {{-- Table Header: entries per page + info --}}
    @if($paginator)
    <div class="px-4 py-3 border-b border-gray-100 dark:border-gray-700 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
        <div class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400">
            <span>Tampilkan</span>
            <form method="GET" class="inline">
                @foreach(request()->except(['per_page', 'page']) as $key => $value)
                    @if(is_array($value))
                        @foreach($value as $v)
                            <input type="hidden" name="{{ $key }}[]" value="{{ $v }}">
                        @endforeach
                    @else
                        <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                    @endif
                @endforeach
                <select name="per_page" onchange="this.form.submit()"
                    class="rounded-md border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-sm px-2 py-1 dark:text-white focus:ring-blue-500 focus:border-blue-500">
                    @foreach([10, 20, 50, 100] as $size)
                        <option value="{{ $size }}" {{ request('per_page', 20) == $size ? 'selected' : '' }}>{{ $size }}</option>
                    @endforeach
                </select>
            </form>
            <span>data</span>
        </div>
        <div class="text-sm text-gray-500 dark:text-gray-400">
            Menampilkan <span class="font-medium text-gray-700 dark:text-gray-300">{{ $paginator->firstItem() ?? 0 }}</span>
            —
            <span class="font-medium text-gray-700 dark:text-gray-300">{{ $paginator->lastItem() ?? 0 }}</span>
            dari
            <span class="font-medium text-gray-700 dark:text-gray-300">{{ $paginator->total() }}</span> data
        </div>
    </div>
    @endif

    {{-- Table Content (slot) --}}
    <div class="overflow-x-auto">
        {{ $slot }}
    </div>

    {{-- Pagination --}}
    @if($paginator && $paginator->hasPages())
    <div class="px-4 py-3 border-t border-gray-100 dark:border-gray-700">
        {{ $paginator->links() }}
    </div>
    @endif
</div>

@once
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('[data-sortable]').forEach(function(table) {
        const headers = table.querySelectorAll('th[data-sort]');
        headers.forEach(function(header, colIndex) {
            header.style.cursor = 'pointer';
            header.classList.add('select-none');

            // Add sort icon
            const icon = document.createElement('span');
            icon.className = 'ml-1 inline-block text-gray-400 text-xs';
            icon.innerHTML = '⇅';
            header.appendChild(icon);

            header.addEventListener('click', function() {
                const tbody = table.querySelector('tbody');
                const rows = Array.from(tbody.querySelectorAll('tr'));
                const idx = Array.from(header.parentNode.children).indexOf(header);
                const asc = header.dataset.sortDir !== 'asc';
                header.dataset.sortDir = asc ? 'asc' : 'desc';

                // Reset other headers
                headers.forEach(h => {
                    if (h !== header) {
                        h.dataset.sortDir = '';
                        const ic = h.querySelector('span');
                        if (ic) ic.innerHTML = '⇅';
                    }
                });
                icon.innerHTML = asc ? '↑' : '↓';

                rows.sort(function(a, b) {
                    const aText = (a.children[idx]?.textContent || '').trim().toLowerCase();
                    const bText = (b.children[idx]?.textContent || '').trim().toLowerCase();
                    const aNum = parseFloat(aText.replace(/[^\d.-]/g, ''));
                    const bNum = parseFloat(bText.replace(/[^\d.-]/g, ''));

                    if (!isNaN(aNum) && !isNaN(bNum)) {
                        return asc ? aNum - bNum : bNum - aNum;
                    }
                    return asc ? aText.localeCompare(bText) : bText.localeCompare(aText);
                });

                rows.forEach(row => tbody.appendChild(row));
            });
        });
    });
});
</script>
@endpush
@endonce
