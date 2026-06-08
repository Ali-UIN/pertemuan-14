@php
    $tersedia = $buku->stok > 0;
@endphp

<div class="card h-100 shadow-sm">
    <div class="card-body">
        {{-- Checkbox bulk delete --}}
        <div class="form-check mb-2">
            <input type="checkbox"
                   name="buku_ids[]"
                   value="{{ $buku->id }}"
                   class="form-check-input buku-checkbox"
                   id="buku-{{ $buku->id }}"
                   style="width:18px;height:18px;cursor:pointer;">
            <label class="form-check-label text-muted small" for="buku-{{ $buku->id }}">Pilih</label>
        </div>

        <div class="d-flex align-items-start gap-3">
            <div class="rounded bg-light text-primary d-flex align-items-center justify-content-center" style="width:56px;height:56px;">
                <i class="bi bi-book" style="font-size:1.5rem;"></i>
            </div>
            <div class="flex-grow-1">
                <div class="d-flex align-items-center gap-2 mb-1">
                    <span class="badge bg-info text-dark">{{ $buku->kategori }}</span>
                    @if ($tersedia)
                        <span class="badge bg-success">Tersedia</span>
                    @else
                        <span class="badge bg-danger">Habis</span>
                    @endif
                </div>
                <h5 class="mb-1">{{ $buku->judul }}</h5>
                <div class="text-muted small">Pengarang: {{ $buku->pengarang }}</div>
            </div>
        </div>

        <hr>

        <div class="d-flex justify-content-between align-items-center">
            <div>
                <div class="text-muted small">Harga</div>
                <div class="fw-semibold">{{ $buku->harga_format }}</div>
            </div>
            <div class="text-end">
                <div class="text-muted small">Stok</div>
                <div class="fw-semibold">{{ $buku->stok }}</div>
            </div>
        </div>
    </div>

    @if ($showActions)
        <div class="card-footer bg-white">
            <div class="btn-group-vertical d-grid gap-2">
                <a href="{{ route('buku.show', $buku->id) }}" class="btn btn-sm btn-info text-white">
                    <i class="bi bi-eye"></i> Detail
                </a>
                <a href="{{ route('buku.edit', $buku->id) }}" class="btn btn-sm btn-warning">
                    <i class="bi bi-pencil"></i> Edit
                </a>

                {{-- Delete Button --}}
                <form action="{{ route('buku.destroy', $buku->id) }}"
                      method="POST"
                      class="d-inline delete-form">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="btn btn-sm btn-danger w-100 btn-delete"
                            data-judul="{{ $buku->judul }}">
                        <i class="bi bi-trash"></i> Hapus
                    </button>
                </form>

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

        // Loading state saat submit form
        document.querySelectorAll('form').forEach(form => {
            form.addEventListener('submit', function() {
                const submitBtn = this.querySelector('button[type="submit"]');
                if (submitBtn && !this.classList.contains('delete-form')) {
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Menyimpan...';
                }
            });
        });
    </script>
    @endpush
@endonce
            </div>
        </div>
    @endif
</div>