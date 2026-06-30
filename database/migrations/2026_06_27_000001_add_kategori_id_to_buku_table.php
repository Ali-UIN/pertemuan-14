<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Tambah kolom foreign key kategori_id (nullable agar aman untuk data lama)
        Schema::table('buku', function (Blueprint $table) {
            $table->foreignId('kategori_id')
                  ->nullable()
                  ->after('judul')
                  ->constrained('kategori')
                  ->nullOnDelete();
        });

        // 2. Ubah kolom enum 'kategori' menjadi string nullable agar bisa menampung
        //    nama kategori apa pun (sinkron dengan tabel kategori).
        Schema::table('buku', function (Blueprint $table) {
            $table->string('kategori', 50)->nullable()->change();
        });

        // 3. Backfill: isi kategori_id berdasarkan kecocokan nama kategori.
        foreach (DB::table('kategori')->get() as $kat) {
            DB::table('buku')
                ->where('kategori', $kat->nama_kategori)
                ->update(['kategori_id' => $kat->id]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('buku', function (Blueprint $table) {
            $table->dropForeign(['kategori_id']);
            $table->dropColumn('kategori_id');
        });
    }
};
