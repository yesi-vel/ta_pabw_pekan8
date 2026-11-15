<?php

namespace Modules\Peminjaman\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;
use Modules\Buku\Models\Buku;

class Peminjaman extends Model
{
    use HasFactory;

    // Sesuaikan nama tabel di database (biasanya plural/pakai 's')
    protected $table = 'peminjamans';

    // Kolom yang diizinkan untuk mass assignment (mencegah error 500 saat create)
    protected $fillable = [
        'user_id',
        'buku_id',
        'tanggal_pinjam',
        'tanggal_kembali',
        'status',
        'bukti',
    ];

    // Relasi ke tabel User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke tabel Buku
    public function buku()
    {
        return $this->belongsTo(Buku::class);
    }
}