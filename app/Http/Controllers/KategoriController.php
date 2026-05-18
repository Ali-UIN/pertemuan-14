<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function index()
    {
        $kategori_list = [
            [
                'id' => 1,
                'nama' => 'Programming',
                'deskripsi' => 'Buku pemrograman dan coding',
                'jumlah_buku' => 25
            ],
            [
                'id' => 2,
                'nama' => 'Database',
                'deskripsi' => 'Buku tentang database dan SQL',
                'jumlah_buku' => 18
            ],
            [
                'id' => 3,
                'nama' => 'Jaringan',
                'deskripsi' => 'Buku jaringan komputer dan internet',
                'jumlah_buku' => 12
            ],
            [
                'id' => 4,
                'nama' => 'Desain Web',
                'deskripsi' => 'Buku UI, UX, dan desain web',
                'jumlah_buku' => 14
            ],
            [
                'id' => 5,
                'nama' => 'Sistem Operasi',
                'deskripsi' => 'Buku tentang Linux, Windows, dan OS',
                'jumlah_buku' => 9
            ],
        ];

        return view('kategori.index', compact('kategori_list'));
    }

    public function show($id)
    {
        $kategori_data = [
            1 => [
                'id' => 1,
                'nama' => 'Programming',
                'deskripsi' => 'Buku pemrograman dan coding',
                'jumlah_buku' => 25
            ],
            2 => [
                'id' => 2,
                'nama' => 'Database',
                'deskripsi' => 'Buku tentang database dan SQL',
                'jumlah_buku' => 18
            ],
            3 => [
                'id' => 3,
                'nama' => 'Jaringan',
                'deskripsi' => 'Buku jaringan komputer dan internet',
                'jumlah_buku' => 12
            ],
            4 => [
                'id' => 4,
                'nama' => 'Desain Web',
                'deskripsi' => 'Buku UI, UX, dan desain web',
                'jumlah_buku' => 14
            ],
            5 => [
                'id' => 5,
                'nama' => 'Sistem Operasi',
                'deskripsi' => 'Buku tentang Linux, Windows, dan OS',
                'jumlah_buku' => 9
            ],
        ];

        if (!isset($kategori_data[$id])) {
            abort(404, 'Kategori tidak ditemukan');
        }

        $kategori = $kategori_data[$id];

        $buku_by_kategori = [
            1 => [
                ['judul' => 'Belajar Laravel', 'pengarang' => 'Andi', 'tahun' => 2024],
                ['judul' => 'PHP Dasar', 'pengarang' => 'Budi', 'tahun' => 2023],
                ['judul' => 'OOP Modern', 'pengarang' => 'Siti', 'tahun' => 2024],
            ],
            2 => [
                ['judul' => 'MySQL Praktis', 'pengarang' => 'Doni', 'tahun' => 2022],
                ['judul' => 'PostgreSQL Lanjut', 'pengarang' => 'Rina', 'tahun' => 2023],
            ],
            3 => [
                ['judul' => 'Jaringan Komputer', 'pengarang' => 'Agus', 'tahun' => 2021],
                ['judul' => 'TCP/IP Fundamental', 'pengarang' => 'Nina', 'tahun' => 2022],
            ],
            4 => [
                ['judul' => 'UI Design', 'pengarang' => 'Arif', 'tahun' => 2023],
                ['judul' => 'UX Research', 'pengarang' => 'Dina', 'tahun' => 2024],
            ],
            5 => [
                ['judul' => 'Linux Dasar', 'pengarang' => 'Iwan', 'tahun' => 2020],
                ['judul' => 'Windows Internals', 'pengarang' => 'Rafi', 'tahun' => 2023],
            ],
        ];

        $buku_list = $buku_by_kategori[$id] ?? [];

        return view('kategori.show', compact('kategori', 'buku_list'));
    }

    public function search($keyword)
    {
        $kategori_list = [
            [
                'id' => 1,
                'nama' => 'Programming',
                'deskripsi' => 'Buku pemrograman dan coding',
                'jumlah_buku' => 25
            ],
            [
                'id' => 2,
                'nama' => 'Database',
                'deskripsi' => 'Buku tentang database dan SQL',
                'jumlah_buku' => 18
            ],
            [
                'id' => 3,
                'nama' => 'Jaringan',
                'deskripsi' => 'Buku jaringan komputer dan internet',
                'jumlah_buku' => 12
            ],
            [
                'id' => 4,
                'nama' => 'Desain Web',
                'deskripsi' => 'Buku UI, UX, dan desain web',
                'jumlah_buku' => 14
            ],
            [
                'id' => 5,
                'nama' => 'Sistem Operasi',
                'deskripsi' => 'Buku tentang Linux, Windows, dan OS',
                'jumlah_buku' => 9
            ],
        ];

        $hasil = array_values(array_filter($kategori_list, function ($kategori) use ($keyword) {
            return stripos($kategori['nama'], $keyword) !== false
                || stripos($kategori['deskripsi'], $keyword) !== false;
        }));

        return view('kategori.search', compact('keyword', 'hasil'));
    }
}