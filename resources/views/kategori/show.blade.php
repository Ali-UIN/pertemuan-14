@extends('layouts.app')

@section('title', 'Detail Kategori')

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('kategori.index') }}">Kategori</a></li>
        <li class="breadcrumb-item active">{{ $kategori['nama'] }}</li>
    </ol>
</nav>

<div class="card mb-4">
    <div class="card-body">
        <h3>{{ $kategori['nama'] }}</h3>
        <p>{{ $kategori['deskripsi'] }}</p>
        <p><strong>Jumlah buku:</strong> {{ $kategori['jumlah_buku'] }}</p>
    </div>
</div>

<h5>Daftar Buku</h5>
<table class="table table-striped">
    <thead>
        <tr>
            <th>No</th>
            <th>Judul</th>
            <th>Pengarang</th>
            <th>Tahun</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($buku_list as $index => $buku)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $buku['judul'] }}</td>
            <td>{{ $buku['pengarang'] }}</td>
            <td>{{ $buku['tahun'] }}</td>
        </tr>
        @empty
        <tr>
            <td colspan="4" class="text-center">Belum ada buku di kategori ini.</td>
        </tr>
        @endforelse
    </tbody>
</table>
@endsection
