<?php

namespace Tests\Feature\Http\Controllers\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Post;
use App\Models\User;

class PostControllerTest extends TestCase
{
    use WithFaker;
    /**
     * A basic feature test example.
     */
    public function test_store_data(): void
    {
        $title = $this->faker->text(10);

        $user = User::factory()->create();
        $post = Post::factory()->create();

        $response = $this->actingAs($user)
        ->post(route('api.post.create'), [
            'title' => $title,
            'id_creator' => 1,
            'id_category' => 1,
            'slug' => strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $title))),
            'content' => $this->faker->text(100),
            'created_at' => round(microtime(true)),
            'updated_a' => round(microtime(true)),
        ]);

        $response->assertStatus(200);
    }
}
