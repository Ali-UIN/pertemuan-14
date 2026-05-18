<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PerpustakaanController;
use App\Http\Controllers\KategoriController;

Route::get('/kategori', [KategoriController::class, 'index'])->name('kategori.index');
Route::get('/kategori/search/{keyword}', [KategoriController::class, 'search'])->name('kategori.search');
Route::get('/kategori/{id}', [KategoriController::class, 'show'])->name('kategori.show');

Route::get('/', function () {
    return view('welcome');
});

// // Route baru - return text
// // Route baru - return text
// Route::get('/hello', function () {
//     return 'Hello dari Laravel!';
// });
 
// // Route dengan HTML
// Route::get('/info', function () {
//     return '<h1>Sistem Perpustakaan</h1><p>Selamat datang!</p>';
// });
 
// // Route dengan JSON
// Route::get('/buku', function () {
//     return [
//         'judul' => 'Laravel Programming',
//         'pengarang' => 'John Doe',
//         'harga' => 150000
//     ];
// });

// // Route dengan parameter required
// Route::get('/buku/{id}', function ($id) {
//     return "Detail buku dengan ID: " . $id;
// });
 
// // Route dengan parameter optional
// Route::get('/kategori/{nama?}', function ($nama = 'Semua Kategori') {
//     return "Menampilkan kategori: " . $nama;
// });
 
// // Route dengan multiple parameters
// Route::get('/search/{kategori}/{keyword}', function ($kategori, $keyword) {
//     return "Cari buku kategori: $kategori dengan keyword: $keyword";
// });

// // Named route
// Route::get('/perpustakaan', function () {
//     return 'Halaman Perpustakaan';
// })->name('perpus.home');
 
// // Gunakan named route
// Route::get('/test-route', function () {
//     $url = route('perpus.home');
//     return "URL perpustakaan: " . $url;
// });

// Route::get('/perpustakaan', function () {
//     // Data untuk dikirim ke view
//     $nama_sistem = "Sistem Perpustakaan Laravel";
//     $versi = "12.x";
//     $total_buku = 5;
    
//     $buku_list = [
//         [
//             'judul' => 'Pemrograman PHP',
//             'pengarang' => 'Budi Raharjo',
//             'harga' => 75000,
//             'stok' => 10
//         ],
//         [
//             'judul' => 'Laravel Framework',
//             'pengarang' => 'Andi Nugroho',
//             'harga' => 125000,
//             'stok' => 5
//         ],
//         [
//             'judul' => 'MySQL Database',
//             'pengarang' => 'Siti Aminah',
//             'harga' => 95000,
//             'stok' => 0
//         ],
//         [
//             'judul' => 'Web Design',
//             'pengarang' => 'Dedi Santoso',
//             'harga' => 85000,
//             'stok' => 8
//         ],
//         [
//             'judul' => 'JavaScript Modern',
//             'pengarang' => 'Rina Wijaya',
//             'harga' => 80000,
//             'stok' => 12
//         ]
//     ];
    
//     // Return view dengan data
//     return view('perpustakaan.index', [
//         'nama_sistem' => $nama_sistem,
//         'versi' => $versi,
//         'total_buku' => $total_buku,
//         'buku_list' => $buku_list
//     ]);
// });

// Route::get('/perpustakaan', function () {
//     $nama_sistem = "Sistem Perpustakaan Laravel";
//     $versi = "12.x";
//     $total_buku = 5;
    
//     $buku_list = [
//         // ... data buku sama
//     ];
    
//     // Menggunakan compact() - lebih praktis
//     return view('perpustakaan.index', compact('nama_sistem', 'versi', 'total_buku', 'buku_list'));
// });

// Route menggunakan Controller
Route::get('/perpustakaan', [PerpustakaanController::class, 'index'])->name('perpustakaan.index');
Route::get('/buku/{id}', [PerpustakaanController::class, 'show'])->name('perpustakaan.show');
Route::get('/about', [PerpustakaanController::class, 'about'])->name('perpustakaan.about');

Route::get('/anggota', function () {
    $anggota_list = [
        [
            'id' => 1,
            'kode' => 'AGT-001',
            'nama' => 'Budi Raharjo',
            'email' => 'budi@email.com',
            'telepon' => '081234567890',
            'alamat' => 'Jakarta',
            'status' => 'Aktif'
        ],
        [
            'id' => 2,
            'kode' => 'AGT-002',
            'nama' => 'Siti Aminah',
            'email' => 'siti@email.com',
            'telepon' => '081234567891',
            'alamat' => 'Bandung',
            'status' => 'Aktif'
        ],
        [
            'id' => 3,
            'kode' => 'AGT-003',
            'nama' => 'Andi Wijaya',
            'email' => 'andi@email.com',
            'telepon' => '081234567892',
            'alamat' => 'Surabaya',
            'status' => 'Nonaktif'
        ],
        [
            'id' => 4,
            'kode' => 'AGT-004',
            'nama' => 'Rina Susanti',
            'email' => 'rina@email.com',
            'telepon' => '081234567893',
            'alamat' => 'Yogyakarta',
            'status' => 'Aktif'
        ],
        [
            'id' => 5,
            'kode' => 'AGT-005',
            'nama' => 'Dedi Pratama',
            'email' => 'dedi@email.com',
            'telepon' => '081234567894',
            'alamat' => 'Semarang',
            'status' => 'Aktif'
        ],
    ];

    return view('anggota.index', compact('anggota_list'));
})->name('anggota.index');


Route::get('/anggota/{id}', function ($id) {
    $anggota_list = [
        1 => [
            'id' => 1,
            'kode' => 'AGT-001',
            'nama' => 'Budi Santoso',
            'email' => 'budi@email.com',
            'telepon' => '081234567890',
            'alamat' => 'Jakarta',
            'status' => 'Aktif'
        ],
        2 => [
            'id' => 2,
            'kode' => 'AGT-002',
            'nama' => 'Siti Aminah',
            'email' => 'siti@email.com',
            'telepon' => '081234567891',
            'alamat' => 'Bandung',
            'status' => 'Aktif'
        ],
        3 => [
            'id' => 3,
            'kode' => 'AGT-003',
            'nama' => 'Andi Wijaya',
            'email' => 'andi@email.com',
            'telepon' => '081234567892',
            'alamat' => 'Surabaya',
            'status' => 'Nonaktif'
        ],
        4 => [
            'id' => 4,
            'kode' => 'AGT-004',
            'nama' => 'Rina Susanti',
            'email' => 'rina@email.com',
            'telepon' => '081234567893',
            'alamat' => 'Yogyakarta',
            'status' => 'Aktif'
        ],
        5 => [
            'id' => 5,
            'kode' => 'AGT-005',
            'nama' => 'Dedi Pratama',
            'email' => 'dedi@email.com',
            'telepon' => '081234567894',
            'alamat' => 'Semarang',
            'status' => 'Aktif'
        ],
    ];

    if (!isset($anggota_list[$id])) {
        abort(404, 'Anggota tidak ditemukan');
    }

    $anggota = $anggota_list[$id];

    return view('anggota.show', compact('anggota'));
})->name('anggota.show');

Route::get('/kategori', [KategoriController::class, 'index'])->name('kategori.index');
Route::get('/kategori/search/{keyword}', [KategoriController::class, 'search'])->name('kategori.search');
Route::get('/kategori/{id}', [KategoriController::class, 'show'])->name('kategori.show');