<?php

namespace Tests\Feature;

use App\Models\BRT;
use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BRTManagementTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_view_their_brts()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        BRT::factory()->create(['user_id' => $user->id]);

        $response = $this->getJson('/api/brts');
        $response->assertStatus(200);
        $response->assertJsonCount(1);
    }

    /** @test */
    public function user_can_create_a_brt()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $data = [
            'reserved_amount' => 100.00,
        ];

        $response = $this->postJson('/api/brts', $data);
        $response->assertStatus(201);
        $this->assertDatabaseHas('brts', ['reserved_amount' => 100.00]);
    }

    /** @test */
    public function user_can_update_their_brt()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $brt = BRT::factory()->create(['user_id' => $user->id]);

        $data = ['reserved_amount' => 200.00, 'status' => 'expired'];

        $response = $this->putJson("/api/brts/{$brt->id}", $data);
        $response->assertStatus(200);
        $this->assertDatabaseHas('brts', ['reserved_amount' => 200.00, 'status' => 'expired']);
    }

    /** @test */
    public function user_can_delete_their_brt()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $brt = BRT::factory()->create(['user_id' => $user->id]);

        $response = $this->deleteJson("/api/brts/{$brt->id}");
        $response->assertStatus(200);
        $this->assertDatabaseMissing('brts', ['id' => $brt->id]);
    }

    /** @test */
    public function it_returns_404_if_brt_not_found()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->getJson('/api/brts/999');
        $response->assertStatus(404);
    }
}
