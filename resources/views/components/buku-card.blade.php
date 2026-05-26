@php
    $tersedia = $buku->stok > 0;
@endphp

<div class="card h-100 shadow-sm">
    <div class="card-body">
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
            <div class="d-flex gap-2">
                <a href="{{ route('buku.show', $buku->id) }}" class="btn btn-sm btn-outline-primary">
                    <i class="bi bi-eye"></i> Detail
                </a>
                <a href="{{ route('buku.edit', $buku->id) }}" class="btn btn-sm btn-outline-warning">
                    <i class="bi bi-pencil"></i> Edit
                </a>
            </div>
        </div>
    @endif
</div>