<?php

namespace Modules\Kategori\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Kategori\Models\Kategori;

/**
 * @extends Factory<Kategori>
 */
class KategoriFactory extends Factory
{
    protected $model = Kategori::class;

    public function definition(): array
    {
        return [
            'nama_kategori' => fake()->randomElement([
                'Pungli',
                'Pemerasan',
                'Parkir Liar',
                'Calon Penipuan',
                'Lainnya'
            ]),
        ];
    }
}
