@extends('layouts.app')

@section('title', 'Detail Buku')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-10">

        <div class="card">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h4 class="mb-0">
                    <i class="bi bi-book"></i>
                    Detail Buku
                </h4>
                <span class="badge bg-{{ $buku->stok > 0 ? 'success' : 'danger' }} fs-6">
                    {{ $buku->stok > 0 ? 'Tersedia' : 'Habis' }}
                </span>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-8">
                        <h3 class="mb-1">{{ $buku->judul }}</h3>
                        <p class="text-muted mb-3">
                            <i class="bi bi-tag"></i> {{ $buku->kategori }}
                            &nbsp;&bull;&nbsp;
                            <i class="bi bi-translate"></i> {{ $buku->bahasa }}
                        </p>

                        <table class="table table-borderless">
                            <tbody>
                                <tr>
                                    <th width="160" class="text-muted">Kode Buku</th>
                                    <td>{{ $buku->kode_buku }}</td>
                                </tr>
                                <tr>
                                    <th class="text-muted">Pengarang</th>
                                    <td>{{ $buku->pengarang }}</td>
                                </tr>
                                <tr>
                                    <th class="text-muted">Penerbit</th>
                                    <td>{{ $buku->penerbit }}</td>
                                </tr>
                                <tr>
                                    <th class="text-muted">Tahun Terbit</th>
                                    <td>{{ $buku->tahun_terbit }}</td>
                                </tr>
                                <tr>
                                    <th class="text-muted">ISBN</th>
                                    <td>{{ $buku->isbn ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th class="text-muted">Harga</th>
                                    <td>Rp {{ number_format($buku->harga, 0, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <th class="text-muted">Stok</th>
                                    <td>
                                        <span class="badge bg-{{ $buku->stok > 0 ? 'success' : 'danger' }}">
                                            {{ $buku->stok }} eksemplar
                                        </span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        @if($buku->deskripsi)
                            <div class="mt-2">
                                <h6 class="text-muted">Deskripsi</h6>
                                <p>{{ $buku->deskripsi }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <small class="text-muted">
                    <i class="bi bi-info-circle"></i>
                    Ditambahkan: {{ $buku->created_at->format('d M Y H:i') }}
                    &nbsp;&bull;&nbsp;
                    Diupdate: {{ $buku->updated_at->format('d M Y H:i') }}
                </small>
            </div>
        </div>

        <div class="d-flex justify-content-between mt-3">
            <a href="{{ route('buku.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
            <div>
                <a href="{{ route('buku.edit', $buku->id) }}" class="btn btn-warning">
                    <i class="bi bi-pencil-square"></i> Edit
                </a>
                <form action="{{ route('buku.destroy', $buku->id) }}" method="POST" class="d-inline delete-form">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="btn btn-danger btn-delete"
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
@endsection
