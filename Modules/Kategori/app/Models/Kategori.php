<?php

namespace Modules\Kategori\Models;

use Modules\Laporan\Models\Laporan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Kategori\Database\Factories\KategoriFactory;

class Kategori extends Model
{
    use HasFactory;

    protected $table = 'kategori_laporan';

    protected $fillable = [
        'nama_kategori',
        'deskripsi'
    ];

    protected static function newFactory()
    {
        return KategoriFactory::new();
    }

    public function laporan(): HasMany
    {
        return $this->hasMany(Laporan::class, 'id_kategori', 'id');
    }
}
