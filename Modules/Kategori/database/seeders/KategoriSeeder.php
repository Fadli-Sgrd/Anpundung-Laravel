<?php

namespace Modules\Kategori\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Kategori\Models\Kategori;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            'Pungli',
            'Pemerasan',
            'Parkir Liar',
            'Calon Penipuan',
            'Lainnya'
        ];

        foreach ($data as $nama) {
            Kategori::create([
                'nama_kategori' => $nama
            ]);
        }
    }
}
