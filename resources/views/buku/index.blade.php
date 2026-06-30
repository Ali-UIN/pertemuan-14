<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <i class="bi bi-book"></i> Daftar Buku
            </h2>
            <div class="flex gap-2">
                <a href="{{ route('buku.export') }}"
                   class="inline-flex items-center px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-md hover:bg-green-700">
                    <i class="bi bi-file-earmark-excel mr-1"></i> Export Excel
                </a>
                <a href="{{ route('buku.create') }}"
                   class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-md hover:bg-indigo-700">
                    <i class="bi bi-plus-circle mr-1"></i> Tambah Buku
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Statistik --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white shadow-sm sm:rounded-lg p-6 flex items-center justify-between border-l-4 border-indigo-500">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Total Buku</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ $totalBuku }}</p>
                    </div>
                    <i class="bi bi-book-fill text-indigo-500 text-4xl"></i>
                </div>
                <div class="bg-white shadow-sm sm:rounded-lg p-6 flex items-center justify-between border-l-4 border-green-500">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Buku Tersedia</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ $bukuTersedia }}</p>
                    </div>
                    <i class="bi bi-check-circle-fill text-green-500 text-4xl"></i>
                </div>
                <div class="bg-white shadow-sm sm:rounded-lg p-6 flex items-center justify-between border-l-4 border-red-500">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Buku Habis</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ $bukuHabis }}</p>
                    </div>
                    <i class="bi bi-x-circle-fill text-red-500 text-4xl"></i>
                </div>
            </div>

            {{-- Search & Filter --}}
            @php
                $kategoriOptions = $kategoriOptions ?? ['Programming', 'Database', 'Web Design', 'Networking', 'Data Science'];
                $tahunOptions = $tahunOptions ?? collect($bukus)->pluck('tahun_terbit')->unique()->sortDesc()->values();
            @endphp
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <h6 class="font-semibold text-gray-700 mb-3"><i class="bi bi-search"></i> Search & Filter</h6>
                <form method="GET" action="{{ route('buku.search') }}" class="grid grid-cols-1 md:grid-cols-12 gap-2">
                    <input type="text" name="keyword" placeholder="Cari judul/pengarang/penerbit"
                           value="{{ request('keyword') }}"
                           class="md:col-span-4 border-gray-300 rounded-md shadow-sm text-sm">
                    <select name="kategori" class="md:col-span-2 border-gray-300 rounded-md shadow-sm text-sm">
                        <option value="">Semua Kategori</option>
                        @foreach ($kategoriOptions as $item)
                            <option value="{{ $item }}" @selected(request('kategori') === $item)>{{ $item }}</option>
                        @endforeach
                    </select>
                    <select name="tahun" class="md:col-span-2 border-gray-300 rounded-md shadow-sm text-sm">
                        <option value="">Semua Tahun</option>
                        @foreach ($tahunOptions as $tahun)
                            <option value="{{ $tahun }}" @selected((string) request('tahun') === (string) $tahun)>{{ $tahun }}</option>
                        @endforeach
                    </select>
                    <select name="ketersediaan" class="md:col-span-2 border-gray-300 rounded-md shadow-sm text-sm">
                        <option value="">Semua</option>
                        <option value="tersedia" @selected(request('ketersediaan') === 'tersedia')>Tersedia</option>
                        <option value="habis" @selected(request('ketersediaan') === 'habis')>Habis</option>
                    </select>
                    <div class="md:col-span-2 flex gap-2">
                        <button type="submit" class="flex-1 px-3 py-2 bg-indigo-600 text-white text-sm rounded-md hover:bg-indigo-700">Cari</button>
                        <a href="{{ route('buku.index') }}" class="flex-1 text-center px-3 py-2 border border-gray-300 text-gray-600 text-sm rounded-md hover:bg-gray-50">Reset</a>
                    </div>
                </form>
            </div>

            {{-- Bulk Action Toolbar --}}
            @if ($bukus->count() > 0)
                <div class="flex justify-between items-center px-4 py-3 bg-white border border-gray-200 rounded-lg">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" id="select-all" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                        <span class="font-medium text-gray-700">Pilih Semua</span>
                        <span id="selected-count" class="px-2 py-0.5 text-xs rounded-full bg-gray-200 text-gray-700">0 dipilih</span>
                    </label>
                    <button type="button" id="btn-bulk-delete" disabled
                            class="px-3 py-1.5 text-sm rounded-md bg-red-500 text-white hover:bg-red-600 disabled:opacity-50 disabled:cursor-not-allowed">
                        <i class="bi bi-trash"></i> Hapus Terpilih (<span id="count-label">0</span>)
                    </button>
                </div>
            @endif

            <form action="{{ route('buku.bulk-delete') }}" method="POST" id="bulk-delete-form" class="hidden">
                @csrf
            </form>

            {{-- Daftar Buku --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @forelse ($bukus as $buku)
                    <x-buku-card :buku="$buku" />
                @empty
                    <div class="col-span-full">
                        <div class="px-4 py-3 rounded-lg bg-blue-100 text-blue-800">
                            <i class="bi bi-info-circle"></i> Tidak ada data buku
                            @isset($kategori) dengan kategori <strong>{{ $kategori }}</strong> @endisset
                        </div>
                    </div>
                @endforelse
            </div>

            @if ($bukus->count() > 0)
                <p class="text-center text-gray-500 text-sm">
                    Menampilkan {{ $bukus->count() }} buku
                    @isset($kategori) dari kategori <strong>{{ $kategori }}</strong> @endisset
                </p>
            @endif
        </div>
    </div>

    @push('scripts')
    <script>
        document.getElementById('select-all')?.addEventListener('change', function() {
            document.querySelectorAll('input[name="buku_ids[]"]').forEach(cb => cb.checked = this.checked);
            updateBulkBar();
        });

        document.addEventListener('change', function(e) {
            if (e.target.name === 'buku_ids[]') updateBulkBar();
        });

        function updateBulkBar() {
            const checked = document.querySelectorAll('input[name="buku_ids[]"]:checked');
            const total   = document.querySelectorAll('input[name="buku_ids[]"]');
            const count   = checked.length;

            document.getElementById('selected-count').textContent = count + ' dipilih';
            document.getElementById('count-label').textContent    = count;
            document.getElementById('btn-bulk-delete').disabled    = count === 0;

            const selectAll = document.getElementById('select-all');
            if (selectAll) {
                selectAll.checked       = count > 0 && count === total.length;
                selectAll.indeterminate = count > 0 && count < total.length;
            }
        }

        document.getElementById('btn-bulk-delete')?.addEventListener('click', function() {
            const count = document.querySelectorAll('input[name="buku_ids[]"]:checked').length;
            Swal.fire({
                title: 'Konfirmasi Hapus',
                text: `Apakah Anda yakin ingin menghapus ${count} buku yang dipilih?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.getElementById('bulk-delete-form');
                    form.querySelectorAll('input[name="buku_ids[]"]').forEach(input => input.remove());
                    document.querySelectorAll('input[name="buku_ids[]"]:checked').forEach(checkbox => {
                        const hiddenInput = document.createElement('input');
                        hiddenInput.type = 'hidden';
                        hiddenInput.name = 'buku_ids[]';
                        hiddenInput.value = checkbox.value;
                        form.appendChild(hiddenInput);
                    });
                    form.submit();
                }
            });
        });
    </script>
    @endpush
</x-app-layout>
