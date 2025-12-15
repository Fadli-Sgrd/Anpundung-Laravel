<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Modules\Kontak\Models\Kontak;
use Modules\Kontak\Database\Seeders\KontakSeeder;
use Modules\Laporan\Database\Seeders\LaporanSeeder;
use Modules\Kategori\Database\Seeders\KategoriSeeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    { {
            $this->call([
                UserSeeder::class,
                KategoriSeeder::class,
                LaporanSeeder::class,
                KontakSeeder::class,
            ]);
        }
    }
}
