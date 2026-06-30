@php
    $tersedia = $buku->stok > 0;
    $showActions = $showActions ?? true;
@endphp

<div class="bg-white rounded-lg shadow-sm border border-gray-100 flex flex-col h-full">
    <div class="p-5 flex-grow">
        {{-- Checkbox bulk delete --}}
        <label class="inline-flex items-center gap-2 mb-3 text-xs text-gray-500 cursor-pointer">
            <input type="checkbox"
                   name="buku_ids[]"
                   value="{{ $buku->id }}"
                   class="buku-checkbox rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                   id="buku-{{ $buku->id }}">
            Pilih
        </label>

        <div class="flex items-start gap-3">
            <div class="w-14 h-14 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center shrink-0">
                <i class="bi bi-book text-2xl"></i>
            </div>
            <div class="flex-grow min-w-0">
                <div class="flex items-center gap-2 mb-1 flex-wrap">
                    <span class="px-2 inline-flex text-xs font-semibold rounded-full bg-sky-100 text-sky-800">{{ $buku->kategori }}</span>
                    @if ($tersedia)
                        <span class="px-2 inline-flex text-xs font-semibold rounded-full bg-green-100 text-green-800">Tersedia</span>
                    @else
                        <span class="px-2 inline-flex text-xs font-semibold rounded-full bg-red-100 text-red-800">Habis</span>
                    @endif
                </div>
                <h5 class="font-semibold text-gray-900 truncate">{{ $buku->judul }}</h5>
                <div class="text-gray-500 text-sm">Pengarang: {{ $buku->pengarang }}</div>
            </div>
        </div>

        <hr class="my-4 border-gray-100">

        <div class="flex justify-between items-center">
            <div>
                <div class="text-gray-500 text-xs">Harga</div>
                <div class="font-semibold text-gray-800">{{ $buku->harga_format }}</div>
            </div>
            <div class="text-right">
                <div class="text-gray-500 text-xs">Stok</div>
                <div class="font-semibold text-gray-800">{{ $buku->stok }}</div>
            </div>
        </div>
    </div>

    @if ($showActions)
        <div class="px-5 py-3 bg-gray-50 rounded-b-lg flex gap-2">
            <a href="{{ route('buku.show', $buku->id) }}"
               class="flex-1 text-center px-3 py-1.5 text-sm rounded-md bg-sky-500 text-white hover:bg-sky-600">
                <i class="bi bi-eye"></i> Detail
            </a>
            <a href="{{ route('buku.edit', $buku->id) }}"
               class="flex-1 text-center px-3 py-1.5 text-sm rounded-md bg-amber-400 text-amber-900 hover:bg-amber-500">
                <i class="bi bi-pencil"></i> Edit
            </a>
            <form action="{{ route('buku.destroy', $buku->id) }}" method="POST" class="flex-1 delete-form">
                @csrf
                @method('DELETE')
                <button type="button"
                        class="w-full px-3 py-1.5 text-sm rounded-md bg-red-500 text-white hover:bg-red-600 btn-delete"
                        data-judul="{{ $buku->judul }}">
                    <i class="bi bi-trash"></i> Hapus
                </button>
            </form>
        </div>

@once
    @push('scripts')
    <script>
        // SweetAlert confirmation untuk delete
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
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    </script>
    @endpush
@endonce
    @endif
</div>
