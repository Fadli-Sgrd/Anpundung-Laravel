<?php

namespace Modules\Laporan\Models;

use App\Models\User;
use Modules\Bukti\Models\Bukti;
use Modules\Kategori\Models\Kategori;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Laporan\Database\Factories\LaporanFactory;

class Laporan extends Model
{
    use HasFactory;

    protected $table = 'laporan';
    protected $primaryKey = 'kode_laporan';


    protected $fillable = [
        'judul',
        'tanggal',
        'alamat',
        'deskripsi',
        'id_kategori',
        'user_id',
        'status_tindakan'
    ];


    public function kategori(): BelongsTo
    {
        return $this->belongsTo(Kategori::class, 'id_kategori', 'id');
    }


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function bukti(): HasMany
    {
        return $this->hasMany(Bukti::class, 'kode_laporan', 'kode_laporan');
    }

    protected static function newFactory()
    {
        return LaporanFactory::new();
    }
}
