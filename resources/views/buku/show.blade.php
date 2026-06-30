<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <i class="bi bi-book"></i> Detail Buku
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-4">
            <div class="bg-white shadow-sm sm:rounded-lg overflow-hidden">
                <div class="px-6 py-4 bg-indigo-600 text-white flex justify-between items-center">
                    <h4 class="font-semibold"><i class="bi bi-book"></i> {{ $buku->judul }}</h4>
                    <span class="px-3 py-1 text-sm font-semibold rounded-full {{ $buku->stok > 0 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ $buku->stok > 0 ? 'Tersedia' : 'Habis' }}
                    </span>
                </div>
                <div class="p-6">
                    <p class="text-gray-500 mb-4">
                        <i class="bi bi-tag"></i> {{ $buku->kategori }} &bull;
                        <i class="bi bi-translate"></i> {{ $buku->bahasa }}
                    </p>

                    <dl class="divide-y divide-gray-100">
                        @foreach ([
                            'Kode Buku' => $buku->kode_buku,
                            'Pengarang' => $buku->pengarang,
                            'Penerbit' => $buku->penerbit,
                            'Tahun Terbit' => $buku->tahun_terbit,
                            'ISBN' => $buku->isbn ?? '-',
                            'Harga' => 'Rp ' . number_format($buku->harga, 0, ',', '.'),
                        ] as $label => $value)
                            <div class="py-2 flex">
                                <dt class="w-40 text-sm text-gray-500">{{ $label }}</dt>
                                <dd class="text-sm text-gray-900">{{ $value }}</dd>
                            </div>
                        @endforeach
                        <div class="py-2 flex items-center">
                            <dt class="w-40 text-sm text-gray-500">Stok</dt>
                            <dd>
                                <span class="px-2 inline-flex text-xs font-semibold rounded-full {{ $buku->stok > 0 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $buku->stok }} eksemplar
                                </span>
                            </dd>
                        </div>
                    </dl>

                    @if($buku->deskripsi)
                        <div class="mt-4">
                            <h6 class="text-sm text-gray-500 mb-1">Deskripsi</h6>
                            <p class="text-gray-800">{{ $buku->deskripsi }}</p>
                        </div>
                    @endif
                </div>
                <div class="px-6 py-3 bg-gray-50 text-sm text-gray-500">
                    <i class="bi bi-info-circle"></i>
                    Ditambahkan: {{ $buku->created_at->format('d M Y H:i') }} &bull;
                    Diupdate: {{ $buku->updated_at->format('d M Y H:i') }}
                </div>
            </div>

            <div class="flex justify-between">
                <a href="{{ route('buku.index') }}" class="px-4 py-2 border border-gray-300 text-gray-600 text-sm rounded-md hover:bg-gray-50">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
                <div class="flex gap-2">
                    <a href="{{ route('buku.edit', $buku->id) }}" class="px-4 py-2 bg-amber-500 text-white text-sm rounded-md hover:bg-amber-600">
                        <i class="bi bi-pencil-square"></i> Edit
                    </a>
                    <form action="{{ route('buku.destroy', $buku->id) }}" method="POST" class="delete-form">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="px-4 py-2 bg-red-500 text-white text-sm rounded-md hover:bg-red-600 btn-delete"
                                data-judul="{{ $buku->judul }}">
                            <i class="bi bi-trash"></i> Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.querySelectorAll('.btn-delete').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const form = this.closest('form');
                const judul = this.getAttribute('data-judul');
                Swal.fire({
                    title: 'Konfirmasi Hapus',
                    text: `Apakah Anda yakin ingin menghapus buku "${judul}"?`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) form.submit();
                });
            });
        });
    </script>
    @endpush
</x-app-layout>
