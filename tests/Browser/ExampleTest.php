<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class ExampleTest extends DuskTestCase
{
    /**
     * A basic browser test example.
     */
    public function test_basic_example(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->assertSee('Login')
                ->assertSee('Sign Up')
                ->assertSee('Shop by category')
                ->assertSee('Top New Arrival')
                ->assertSee('Recommended for you');

            $browser->screenshot('example');
        });
    }
}
