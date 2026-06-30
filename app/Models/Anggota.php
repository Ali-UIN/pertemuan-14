<?php
 
namespace App\Models;
 
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Carbon\Carbon;
 
class Anggota extends Model
{
    use HasFactory;
 
    /**
     * Nama tabel yang digunakan oleh model ini.
     *
     * @var string
     */
    protected $table = 'anggota';
 
    /**
     * Kolom yang dapat diisi secara mass assignment.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'kode_anggota',
        'nama',
        'email',
        'telepon',
        'alamat',
        'tanggal_lahir',
        'jenis_kelamin',
        'pekerjaan',
        'tanggal_daftar',
        'status',
    ];
 
    /**
     * Tipe casting untuk atribut.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'tanggal_lahir' => 'date',
        'tanggal_daftar' => 'date',
    ];
 
    /**
     * Accessor untuk menghitung umur.
     */
    public function getUmurAttribute(): int
    {
        return Carbon::parse($this->tanggal_lahir)->age;
    }
 
    /**
     * Accessor untuk lama menjadi anggota (dalam hari).
     */
    public function getLamaAnggotaAttribute(): int
    {
        $tanggalDaftar = Carbon::parse($this->tanggal_daftar)->startOfDay();
        $hariIni = now()->startOfDay();

        return (int) $tanggalDaftar->diffInDays($hariIni);
    }

    /**
     * Accessor untuk badge status anggota.
     */
    public function getStatusBadgeAttribute(): string
    {
        $status = strtolower((string) $this->status);

        if ($status === 'aktif') {
            return '<span class="badge bg-success">Aktif</span>';
        }

        return '<span class="badge bg-secondary">Nonaktif</span>';
    }

    /**
     * Accessor kategori usia berdasarkan umur.
     */
    public function getKategoriUsiaAttribute(): string
    {
        $umur = (int) $this->umur;

        if ($umur < 20) {
            return 'Remaja';
        }

        if ($umur <= 50) {
            return 'Dewasa';
        }

        return 'Senior';
    }
 
    /**
     * Relasi: satu anggota bisa memiliki banyak transaksi peminjaman.
     */
    public function transaksis(): HasMany
    {
        return $this->hasMany(Transaksi::class);
    }

    /**
     * Scope untuk filter anggota aktif.
     */
    public function scopeAktif($query)
    {
        return $query->where('status', 'Aktif');
    }
 
    /**
     * Scope untuk filter berdasarkan jenis kelamin.
     */
    public function scopeJenisKelamin($query, $jenisKelamin)
    {
        return $query->where('jenis_kelamin', $jenisKelamin);
    }

    /**
     * Scope untuk anggota yang terdaftar di bulan ini.
     */
    public function scopeTerdaftarBulanIni($query)
    {
        $now = now();

        return $query->whereMonth('tanggal_daftar', $now->month)
            ->whereYear('tanggal_daftar', $now->year);
    }
}