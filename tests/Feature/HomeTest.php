<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HomeTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200)
            ->assertSee("Login")
            ->assertSee("Sign Up")
            ->assertSee("SHOP BY CATEGORY")
            ->assertSee("TOP NEW ARRIVAL")
            ->assertSee("Recommended for you");
    }
}
