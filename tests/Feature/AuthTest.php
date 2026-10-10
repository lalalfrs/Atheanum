<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_screen_can_be_rendered(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
        $response->assertSee('Masuk ke Akun');
        $response->assertSee('librarian@athenaeum.test');
    }

    public function test_authenticated_user_is_redirected_from_login_screen(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/login');

        $response->assertRedirect(route('dashboard'));
    }

    public function test_users_can_authenticate_using_the_login_screen(): void
    {
        $user = User::factory()->create([
            'email' => 'librarian@athenaeum.test',
            'password' => bcrypt('password'),
        ]);

        $response = $this->post('/login', [
            'email' => 'librarian@athenaeum.test',
            'password' => 'password',
        ]);

        $this->assertAuthenticatedAs($user);
        $response->assertRedirect(route('dashboard'));
        $this->assertDatabaseHas('personal_access_tokens', [
            'tokenable_id' => $user->id,
            'name' => 'athenaeum-session-token',
        ]);
    }

    public function test_users_cannot_authenticate_with_invalid_password(): void
    {
        $user = User::factory()->create([
            'email' => 'librarian@athenaeum.test',
            'password' => bcrypt('password'),
        ]);

        $response = $this->post('/login', [
            'email' => 'librarian@athenaeum.test',
            'password' => 'wrong-password',
        ]);

        $this->assertGuest();
        $response->assertSessionHasErrors('email');
    }

    public function test_users_can_authenticate_via_api_and_receive_sanctum_token(): void
    {
        $user = User::factory()->create([
            'email' => 'librarian@athenaeum.test',
            'password' => bcrypt('password'),
        ]);

        $response = $this->postJson('/api/login', [
            'email' => 'librarian@athenaeum.test',
            'password' => 'password',
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'message',
                'token',
                'token_type',
                'user' => ['id', 'name', 'email'],
            ]);

        $token = $response->json('token');
        $this->assertNotEmpty($token);

        // Akses endpoint api terproteksi menggunakan Bearer token Sanctum
        $userResponse = $this->withHeader('Authorization', 'Bearer '.$token)
            ->getJson('/api/user');

        $userResponse->assertStatus(200)
            ->assertJsonPath('user.email', 'librarian@athenaeum.test');
    }

    public function test_registration_screen_can_be_rendered(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
        $response->assertSee('Daftar Akun Baru');
    }

    public function test_new_users_can_register_via_web_and_receive_sanctum_token(): void
    {
        $response = $this->post('/register', [
            'name' => 'Siti Rahmawati',
            'email' => 'siti@athenaeum.test',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(route('dashboard'));

        $this->assertDatabaseHas('users', [
            'email' => 'siti@athenaeum.test',
            'name' => 'Siti Rahmawati',
        ]);

        $user = User::where('email', 'siti@athenaeum.test')->first();
        $this->assertDatabaseHas('personal_access_tokens', [
            'tokenable_id' => $user->id,
            'name' => 'athenaeum-session-token',
        ]);
    }

    public function test_registration_fails_if_email_is_already_taken(): void
    {
        User::factory()->create([
            'email' => 'existing@athenaeum.test',
        ]);

        $response = $this->post('/register', [
            'name' => 'Another User',
            'email' => 'existing@athenaeum.test',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $this->assertGuest();
        $response->assertSessionHasErrors('email');
    }

    public function test_registration_fails_if_password_confirmation_does_not_match(): void
    {
        $response = $this->post('/register', [
            'name' => 'Budi Santoso',
            'email' => 'budi@athenaeum.test',
            'password' => 'password123',
            'password_confirmation' => 'different-password',
        ]);

        $this->assertGuest();
        $response->assertSessionHasErrors('password');
    }

    public function test_new_users_can_register_via_api_and_receive_sanctum_token(): void
    {
        $response = $this->postJson('/api/register', [
            'name' => 'Arif Wibowo',
            'email' => 'arif@athenaeum.test',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'message',
                'token',
                'token_type',
                'user' => ['id', 'name', 'email'],
            ]);

        $token = $response->json('token');
        $this->assertNotEmpty($token);

        // Akses endpoint api terproteksi menggunakan Bearer token Sanctum baru
        $userResponse = $this->withHeader('Authorization', 'Bearer '.$token)
            ->getJson('/api/user');

        $userResponse->assertStatus(200)
            ->assertJsonPath('user.email', 'arif@athenaeum.test');
    }

    public function test_users_can_logout_and_revoke_sanctum_tokens(): void
    {
        $user = User::factory()->create();
        $token = $user->createToken('test-token')->plainTextToken;

        $response = $this->actingAs($user)->post('/logout');

        $this->assertGuest();
        $response->assertRedirect(route('login'));
        $this->assertDatabaseMissing('personal_access_tokens', [
            'tokenable_id' => $user->id,
        ]);
    }
}
