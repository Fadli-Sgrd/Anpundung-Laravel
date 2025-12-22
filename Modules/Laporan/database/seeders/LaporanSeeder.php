<?php

namespace Modules\Laporan\Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Modules\Laporan\Models\Laporan;
use Modules\Kategori\Models\Kategori;
use Modules\Laporan\Database\Factories\LaporanFactory;

class LaporanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Laporan::factory(30)->recycle([
            User::all(),
            Kategori::all(),
        ])->create();
    }
}
