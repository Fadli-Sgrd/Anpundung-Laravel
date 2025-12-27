<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\News>
 */
class NewsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = $this->faker->sentence;
        return [
            'title' => $title,
            'slug' => \Illuminate\Support\Str::slug($title),
            'excerpt' => $this->faker->paragraph,
            'content' => $this->faker->paragraphs(3, true),
            'image' => 'https://picsum.photos/seed/' . rand(1, 1000) . '/800/450',
            'user_id' => \App\Models\User::where('role', 'admin')->first()?->id ?? 1,
            'published_at' => $this->faker->dateTimeBetween('-1 month', 'now'),
            'is_published' => true,
        ];
    }
}
