<?php
 
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\TransaksiController;
use Illuminate\Support\Facades\Route;
 
// Public routes (tanpa auth)
Route::get('/', function () {
    return redirect()->route('login');
});
 
// Protected routes (dengan auth middleware)
Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Global Search
    Route::get('/search', [SearchController::class, 'index'])->name('search');
 
    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
 
    // Buku - Custom routes (HARUS sebelum resource agar tidak tertangkap /buku/{buku})
    Route::get('/buku/search', [BukuController::class, 'search'])->name('buku.search');
    Route::post('/buku/bulk-delete', [BukuController::class, 'bulkDelete'])->name('buku.bulk-delete');
    Route::get('/buku/export', [BukuController::class, 'export'])->name('buku.export');
    // Buku - CRUD
    Route::resource('buku', BukuController::class);
    Route::get('/buku/kategori/{kategori}', [BukuController::class, 'filterKategori'])->name('buku.kategori');

    // Anggota - Custom routes
    Route::get('/anggota/search', [AnggotaController::class, 'search'])->name('anggota.search');
    Route::get('/anggota/export', [AnggotaController::class, 'export'])->name('anggota.export');
    // Anggota - CRUD
    Route::resource('anggota', AnggotaController::class);

    // Kategori - CRUD
    Route::resource('kategori', KategoriController::class);
    // Transaksi - Custom routes Laporan
    Route::get('/transaksi/laporan', [TransaksiController::class, 'laporan'])->name('transaksi.laporan');
    Route::get('/transaksi/laporan/pdf', [TransaksiController::class, 'laporanPdf'])->name('transaksi.laporan.pdf');
    // Transaksi - CRUD + Custom route pengembalian
    Route::resource('transaksi', TransaksiController::class);
    Route::put('/transaksi/{id}/kembalikan', [TransaksiController::class, 'kembalikan'])
        ->name('transaksi.kembalikan');
});
 
require __DIR__.'/auth.php';