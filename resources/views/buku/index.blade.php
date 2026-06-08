@extends('layouts.app')
 
@section('title', 'Daftar Buku')
 
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>
        <i class="bi bi-book"></i>
        Daftar Buku
    </h1>
    <div class="d-flex gap-2">
        <a href="{{ route('buku.export') }}" class="btn btn-success">
            <i class="bi bi-download"></i> Export CSV
        </a>
        <a href="{{ route('buku.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Tambah Buku
        </a>
    </div>
</div>
 
{{-- Statistik Cards --}}
<div class="row mb-4">
    <div class="col-md-4">
        <div class="card border-primary">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-1">Total Buku</h6>
                        <h2 class="mb-0">{{ $totalBuku }}</h2>
                    </div>
                    <div class="text-primary">
                        <i class="bi bi-book-fill" style="font-size: 3rem;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card border-success">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-1">Buku Tersedia</h6>
                        <h2 class="mb-0">{{ $bukuTersedia }}</h2>
                    </div>
                    <div class="text-success">
                        <i class="bi bi-check-circle-fill" style="font-size: 3rem;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card border-danger">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-1">Buku Habis</h6>
                        <h2 class="mb-0">{{ $bukuHabis }}</h2>
                    </div>
                    <div class="text-danger">
                        <i class="bi bi-x-circle-fill" style="font-size: 3rem;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
 
{{-- Search & Filter --}}
@php
    $kategoriOptions = $kategoriOptions ?? ['Programming', 'Database', 'Web Design', 'Networking', 'Data Science'];
    $tahunOptions = $tahunOptions ?? collect($bukus)->pluck('tahun_terbit')->unique()->sortDesc()->values();
@endphp
<div class="card mb-4">
    <div class="card-body">
        <h6 class="card-title">
            <i class="bi bi-search"></i> Search & Filter
        </h6>
        <form method="GET" action="{{ route('buku.search') }}" class="row g-2">
            <div class="col-md-4">
                <input
                    type="text"
                    name="keyword"
                    class="form-control"
                    placeholder="Cari judul/pengarang/penerbit"
                    value="{{ request('keyword') }}"
                />
            </div>
            <div class="col-md-2">
                <select name="kategori" class="form-select">
                    <option value="">Semua Kategori</option>
                    @foreach ($kategoriOptions as $item)
                        <option value="{{ $item }}" @selected(request('kategori') === $item)>
                            {{ $item }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <select name="tahun" class="form-select">
                    <option value="">Semua Tahun</option>
                    @foreach ($tahunOptions as $tahun)
                        <option value="{{ $tahun }}" @selected((string) request('tahun') === (string) $tahun)>
                            {{ $tahun }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <select name="ketersediaan" class="form-select">
                    <option value="">Semua</option>
                    <option value="tersedia" @selected(request('ketersediaan') === 'tersedia')>Tersedia</option>
                    <option value="habis" @selected(request('ketersediaan') === 'habis')>Habis</option>
                </select>
            </div>
            <div class="col-md-2 d-grid gap-2 d-md-flex">
                <button class="btn btn-primary" type="submit">Cari</button>
                <a href="{{ route('buku.index') }}" class="btn btn-outline-secondary">Reset</a>
            </div>
        </form>
    </div>
</div>
 
{{-- Bulk Action Toolbar --}}
@if ($bukus->count() > 0)
<div class="d-flex justify-content-between align-items-center mb-3 px-3 py-2 bg-light rounded border">
    <div class="d-flex align-items-center gap-2">
        <input type="checkbox" id="select-all" class="form-check-input" style="width:18px;height:18px;cursor:pointer;">
        <label for="select-all" class="mb-0 fw-semibold" style="cursor:pointer;">Pilih Semua</label>
        <span id="selected-count" class="badge bg-secondary">0 dipilih</span>
    </div>
    <button type="button" id="btn-bulk-delete" class="btn btn-sm btn-danger" disabled>
        <i class="bi bi-trash"></i> Hapus Terpilih (<span id="count-label">0</span>)
    </button>
</div>
@endif

<form action="{{ route('buku.bulk-delete') }}" method="POST" id="bulk-delete-form" class="d-none">
    @csrf
</form>

{{-- Daftar Buku --}}
<div class="row g-3">
    @forelse ($bukus as $buku)
        <div class="col-md-6 col-lg-4">
            <x-buku-card :buku="$buku" />
        </div>
    @empty
        <div class="col-12">
            <div class="alert alert-info">
                <i class="bi bi-info-circle"></i>
                Tidak ada data buku
                @isset($kategori)
                    dengan kategori <strong>{{ $kategori }}</strong>
                @endisset
            </div>
        </div>
    @endforelse
</div>

@if ($bukus->count() > 0)
    <div class="text-center mt-4">
        <p class="text-muted">
            Menampilkan {{ $bukus->count() }} buku
            @isset($kategori)
                dari kategori <strong>{{ $kategori }}</strong>
            @endisset
        </p>
    </div>
@endif

@push('scripts')
<script>
    // Select All
    document.getElementById('select-all')?.addEventListener('change', function() {
        document.querySelectorAll('input[name="buku_ids[]"]').forEach(cb => {
            cb.checked = this.checked;
        });
        updateBulkBar();
    });

    // Update toolbar saat checkbox individual berubah
    document.addEventListener('change', function(e) {
        if (e.target.name === 'buku_ids[]') {
            updateBulkBar();
        }
    });

    function updateBulkBar() {
        const checked = document.querySelectorAll('input[name="buku_ids[]"]:checked');
        const total   = document.querySelectorAll('input[name="buku_ids[]"]');
        const count   = checked.length;

        document.getElementById('selected-count').textContent = count + ' dipilih';
        document.getElementById('count-label').textContent    = count;

        const btn = document.getElementById('btn-bulk-delete');
        btn.disabled = count === 0;

        // Sinkronisasi select-all checkbox
        const selectAll = document.getElementById('select-all');
        if (selectAll) {
            selectAll.checked       = count > 0 && count === total.length;
            selectAll.indeterminate = count > 0 && count < total.length;
        }
    }

    // SweetAlert konfirmasi bulk delete
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
@endsection