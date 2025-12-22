<?php

namespace Modules\Laporan\Database\Factories;

use App\Models\User;
use Modules\Laporan\Models\Laporan;
use Modules\Kategori\Models\Kategori;
use Illuminate\Database\Eloquent\Factories\Factory;

class LaporanFactory extends Factory
{
    protected $model = Laporan::class;

    public function definition(): array
    {
        return [
            'judul' => fake()->sentence(rand(6, 8)),
            'tanggal' => fake()->date('Y-m-d'),
            'alamat' => fake()->address(),
            'deskripsi' => fake()->paragraphs(1, true),
            // JANGAN query User atau Kategori di sini - seeder yang assign via state()
            'id_kategori' => Kategori::factory(),  // Placeholder, akan di-override oleh seeder
            'user_id' => User::factory(),      // Placeholder, akan di-override oleh seeder
            'status_tindakan' => fake()->randomElement(['Pending', 'Proses', 'Selesai', 'Ditolak']),
        ];
    }

    /**
     * State untuk menggunakan recycled users
     */
    public function withUser(User $user): static
    {
        return $this->state(fn(array $attributes) => [
            'user_id' => $user->id,
        ]);
    }

    /**
     * State untuk menggunakan recycled categories
     */
    public function withKategori(Kategori $kategori): static
    {
        return $this->state(fn(array $attributes) => [
            'id_kategori' => $kategori->id,
        ]);
    }
}
