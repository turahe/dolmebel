<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_screen_can_be_rendered(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
    }

    public function test_new_users_can_register(): void
    {
        $response = $this->post('/register', [
            'username' => 'test.user',
            'email' => 'test@example.com',
            'password' => 'Pa$$WordStr0nG123',
            'password_confirmation' => 'Pa$$WordStr0nG123',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(route('dashboard', absolute: false));
    }

    /**
     * Data provider for registration validation tests.
     */
    public static function registrationValidationDataProvider(): array
    {
        return [
            'missing username' => [
                ['email' => 'john@example.com', 'password' => 'password123', 'password_confirmation' => 'password123'],
                'username',
                'The username field is required.',
            ],
            'invalid email' => [
                ['username' => 'test.user', 'email' => 'not-an-email', 'password' => 'password123', 'password_confirmation' => 'password123'],
                'email',
                'The email field must be a valid email address.',
            ],
            'short password' => [
                ['username' => 'test.user', 'email' => 'john@example.com', 'password' => '123', 'password_confirmation' => '123'],
                'password',
                'The password field must be at least 8 characters.',
            ],
            'passwords do not match' => [
                ['username' => 'test.user', 'email' => 'john@example.com', 'password' => 'password123', 'password_confirmation' => 'differentPassword'],
                'password',
                'The password field confirmation does not match.',
            ],
        ];
    }

    /**
     * Test registration validation using a data provider.
     */
    #[DataProvider('registrationValidationDataProvider')]
    public function test_registration_validation(array $input, $field, $message)
    {
        $response = $this->post('/register', $input);

        $response->assertInvalid([
            $field => $message,
        ]);
    }
}
