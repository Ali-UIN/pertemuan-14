@extends('layouts.app')
 
@section('title', 'Daftar Buku')
 
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>
        <i class="bi bi-book"></i>
        Daftar Buku
    </h1>
    <a href="{{ route('buku.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> Tambah Buku
    </a>
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
@endsection