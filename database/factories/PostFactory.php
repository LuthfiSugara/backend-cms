<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    public function definition(): array
    {
        $title = fake()->text(10);
        $content = fake()->text(100);
        
        return [
            'title' => $title,
            'id_creator' => 1,
            'id_category' => 1,
            'slug' => strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $title))),
            'content' => $content,
            'created_at' => round(microtime(true)),
            'updated_at' => round(microtime(true)),
        ];
    }
}
