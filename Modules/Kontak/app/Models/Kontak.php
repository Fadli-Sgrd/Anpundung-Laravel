<?php

namespace Modules\Kontak\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Kontak extends Model
{
    use HasFactory;

    protected $table = 'kontaks';

    protected $fillable = [
        'nama',
        'email',
        'subject',
        'message',
        'created_at',
        'updated_at',
    ];
}
