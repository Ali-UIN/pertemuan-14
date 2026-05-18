@extends('layouts.app')

@section('title', 'Hasil Pencarian Kategori')

@section('content')
<h1 class="mb-3">Hasil Pencarian</h1>
<p>Keyword: <mark>{{ $keyword }}</mark></p>

@if (count($hasil) === 0)
    <div class="alert alert-warning">Tidak ada kategori yang cocok.</div>
@else
    <div class="list-group">
        @foreach ($hasil as $kategori)
        @php
            $nama = str_ireplace($keyword, '<mark>' . $keyword . '</mark>', $kategori['nama']);
            $deskripsi = str_ireplace($keyword, '<mark>' . $keyword . '</mark>', $kategori['deskripsi']);
        @endphp
        <div class="list-group-item">
            <h5 class="mb-1">{!! $nama !!}</h5>
            <p class="mb-1">{!! $deskripsi !!}</p>
            <small>Jumlah buku: {{ $kategori['jumlah_buku'] }}</small>
            <div class="mt-2">
                <a href="{{ route('kategori.show', $kategori['id']) }}" class="btn btn-outline-primary btn-sm">Detail</a>
            </div>
        </div>
        @endforeach
    </div>
@endif
@endsection
