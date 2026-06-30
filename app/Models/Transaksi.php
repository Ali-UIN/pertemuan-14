<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Transaksi extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_transaksi',
        'anggota_id',
        'buku_id',
        'tanggal_pinjam',
        'tanggal_kembali',
        'tanggal_dikembalikan',
        'status',
        'denda',
        'keterangan',
    ];

    protected $casts = [
        'tanggal_pinjam' => 'date',
        'tanggal_kembali' => 'date',
        'tanggal_dikembalikan' => 'date',
    ];

    // Relationship ke Anggota (belongsTo)
    public function anggota()
    {
        return $this->belongsTo(Anggota::class);
    }

    // Relationship ke Buku (belongsTo)
    public function buku()
    {
        return $this->belongsTo(Buku::class);
    }

    // Scope: transaksi yang TERLAMBAT (masih dipinjam & lewat jatuh tempo)
    public function scopeTerlambat($query)
    {
        return $query->where('status', 'Dipinjam')
                     ->whereDate('tanggal_kembali', '<', now());
    }

    // Accessor untuk durasi peminjaman (hari)
    public function getDurasiPeminjamanAttribute()
    {
        if ($this->tanggal_dikembalikan) {
            return $this->tanggal_pinjam->diffInDays($this->tanggal_dikembalikan);
        }
        return $this->tanggal_pinjam->diffInDays(now());
    }

    // Accessor untuk cek terlambat (hari)
    public function getTerlambatAttribute()
    {
        if ($this->status == 'Dikembalikan') {
            if ($this->tanggal_dikembalikan && $this->tanggal_dikembalikan->gt($this->tanggal_kembali)) {
                return (int) floor($this->tanggal_kembali->diffInDays($this->tanggal_dikembalikan));
            }
            return 0;
        }

        if (now()->gt($this->tanggal_kembali)) {
            return (int) floor($this->tanggal_kembali->diffInDays(now()));
        }

        return 0;
    }

    // Accessor untuk status badge HTML
    public function getStatusBadgeAttribute()
    {
        return $this->status == 'Dipinjam'
            ? '<span class="badge bg-warning text-dark">Dipinjam</span>'
            : '<span class="badge bg-success">Dikembalikan</span>';
    }
}
