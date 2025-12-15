<?php

namespace Modules\Laporan\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Laporan\Models\Laporan;

class LaporanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    { {
            Laporan::create([
                'kode_laporan' => 1001,
                'judul' => 'Pungli Parkir',
                'tanggal' => now(),
                'alamat' => 'Jl. Contoh Bandung',
                'deskripsi' => 'Terjadi pungli di area parkir',
                'id_kategori' => 1,
                'user_id' => 2,
                'status_tindakan' => 'Pending'
            ]);
        }
    }
}
