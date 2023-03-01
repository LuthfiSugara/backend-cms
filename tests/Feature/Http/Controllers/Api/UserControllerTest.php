<?php

namespace Tests\Feature\Http\Controllers\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class UserControllerTest extends TestCase
{
    use WithFaker;
    /**
     * A basic feature test example.
     */
    public function test_stores_data(): void
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)
        ->post(route('api.user.create'), [
            'name' => $this->faker->words(3, true),
            'email' => preg_replace('/@example\..*/', '@domain.com', $this->faker->unique()->safeEmail),
            'role' => 'user',
            'password' => bcrypt('rahasia'),
            'created_at' => round(microtime(true)),
            'updated_a' => round(microtime(true)),
        ]);

        $response->assertStatus(200);
    }
}
