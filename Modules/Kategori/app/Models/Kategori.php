<?php

namespace Modules\Kategori\Models;

use Modules\Laporan\Models\Laporan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Kategori extends Model
{
    use HasFactory;

    protected $table = 'kategori_laporan';

    protected $fillable = [
        'nama_kategori',
        'deskripsi'
    ];


    public function laporan(): HasMany
    {
        return $this->hasMany(Laporan::class, 'id_kategori', 'id');
    }
}
