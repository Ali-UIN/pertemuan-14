@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
    <div>
        <h1 class="mb-1">
            <i class="bi bi-speedometer2"></i> Dashboard
        </h1>
        <div class="text-muted">Ringkasan sistem perpustakaan</div>
    </div>
    <a href="{{ route('home') }}" class="btn btn-outline-primary">
        <i class="bi bi-house-door"></i> Kembali ke Home
    </a>
</div>

{{-- Statistik --}}
<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="card border-primary h-100">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <div class="text-muted">Total Buku</div>
                    <h2 class="mb-0">{{ $totalBuku }}</h2>
                </div>
                <i class="bi bi-book text-primary" style="font-size: 2.5rem;"></i>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-success h-100">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <div class="text-muted">Buku Tersedia</div>
                    <h2 class="mb-0">{{ $bukuTersedia }}</h2>
                </div>
                <i class="bi bi-check-circle text-success" style="font-size: 2.5rem;"></i>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-danger h-100">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <div class="text-muted">Buku Habis</div>
                    <h2 class="mb-0">{{ $bukuHabis }}</h2>
                </div>
                <i class="bi bi-x-circle text-danger" style="font-size: 2.5rem;"></i>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card border-secondary h-100">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <div class="text-muted">Total Anggota</div>
                    <h2 class="mb-0">{{ $totalAnggota }}</h2>
                </div>
                <i class="bi bi-people text-secondary" style="font-size: 2.5rem;"></i>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-success h-100">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <div class="text-muted">Anggota Aktif</div>
                    <h2 class="mb-0">{{ $anggotaAktif }}</h2>
                </div>
                <i class="bi bi-person-check text-success" style="font-size: 2.5rem;"></i>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-warning h-100">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <div class="text-muted">Anggota Nonaktif</div>
                    <h2 class="mb-0">{{ $anggotaNonaktif }}</h2>
                </div>
                <i class="bi bi-person-x text-warning" style="font-size: 2.5rem;"></i>
            </div>
        </div>
    </div>
</div>

{{-- List Terbaru --}}
<div class="row g-3 mb-4">
    <div class="col-lg-6">
        <div class="card h-100">
            <div class="card-header bg-primary text-white">
                <i class="bi bi-book"></i> 5 Buku Terbaru
            </div>
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Kode</th>
                            <th>Judul</th>
                            <th>Stok</th>
                            <th>Tgl</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($bukuTerbaru as $buku)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td><code>{{ $buku->kode_buku }}</code></td>
                                <td>{{ $buku->judul }}</td>
                                <td>
                                    @if ($buku->stok > 0)
                                        <span class="badge bg-success">Tersedia</span>
                                    @else
                                        <span class="badge bg-danger">Habis</span>
                                    @endif
                                </td>
                                <td>{{ optional($buku->created_at)->format('d M Y') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">
                                    Belum ada data buku.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="card h-100">
            <div class="card-header bg-success text-white">
                <i class="bi bi-people"></i> 5 Anggota Terbaru
            </div>
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Kode</th>
                            <th>Nama</th>
                            <th>Status</th>
                            <th>Tgl</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($anggotaTerbaru as $anggota)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td><code>{{ $anggota->kode_anggota }}</code></td>
                                <td>{{ $anggota->nama }}</td>
                                <td>
                                    @if ($anggota->status === 'Aktif')
                                        <span class="badge bg-success">Aktif</span>
                                    @else
                                        <span class="badge bg-secondary">Nonaktif</span>
                                    @endif
                                </td>
                                <td>{{ optional($anggota->created_at)->format('d M Y') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">
                                    Belum ada data anggota.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- Quick Links --}}
<div class="card">
    <div class="card-header bg-secondary text-white">
        <i class="bi bi-link-45deg"></i> Quick Links
    </div>
    <div class="card-body d-flex flex-wrap gap-2">
        <a class="btn btn-outline-primary" href="{{ route('home') }}">
            <i class="bi bi-house-door"></i> Home
        </a>
        <a class="btn btn-outline-success" href="{{ route('anggota.index') }}">
            <i class="bi bi-people"></i> Anggota
        </a>
        <a class="btn btn-outline-primary" href="{{ route('buku.index') }}">
            <i class="bi bi-book"></i> Buku
        </a>
        <a class="btn btn-outline-info" href="#">
            <i class="bi bi-arrow-left-right"></i> Transaksi
        </a>
    </div>
</div>
@endsection