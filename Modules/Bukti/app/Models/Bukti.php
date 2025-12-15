<?php

namespace Modules\Bukti\Models;

use Modules\Laporan\Models\Laporan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Bukti extends Model
{
    use HasFactory;

    protected $table = 'bukti';
    protected $primaryKey = 'kode_bukti';


    protected $fillable = [
        'kode_laporan',
        'jenis',
        'path_file',
        'deskripsi'
    ];


    public function laporan(): BelongsTo
    {
        return $this->belongsTo(Laporan::class, 'kode_laporan', 'kode_laporan');
    }
}
