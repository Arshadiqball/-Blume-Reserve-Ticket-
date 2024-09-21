<?php

namespace Tests\Unit;

use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_has_many_brts()
    {
        $user = User::factory()->create();
        $this->assertTrue(method_exists($user, 'brts'));
    }

    /** @test */
    public function it_has_fillable_properties()
    {
        $user = new User;
        $this->assertEquals(['name', 'email', 'password'], $user->getFillable());
    }

    /** @test */
    public function it_returns_jwt_identifier()
    {
        $user = User::factory()->create();
        $this->assertEquals($user->getKey(), $user->getJWTIdentifier());
    }

    /** @test */
    public function it_returns_jwt_custom_claims()
    {
        $user = User::factory()->create();
        $this->assertEquals([], $user->getJWTCustomClaims());
    }
}
