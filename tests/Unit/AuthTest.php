<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\TestCase;
use Illuminate\Support\Facades\Artisan;
use Tests\CreatesApplication;
use App\Models\User;

class AuthTest extends TestCase
{
    use CreatesApplication;
    
    public function setUp(): void
    {
        parent::setUp();
        // Jalankan migrasi sebelum setiap pengujian
        Artisan::call('migrate');
    }

    public function tearDown(): void
    {
        // Rollback migrasi setelah setiap pengujian
        Artisan::call('migrate:rollback');
        parent::tearDown();
    }

    private function getToken()
    {
        User::create([
            'name' => 'test',
            'email' => 'test@test.com',
            'password' => bcrypt('test12345') // Gunakan bcrypt untuk mengenkripsi password
        ]);

        $loginData = [
            'email' => 'test@test.com',
            'password' => 'test12345'
        ];

        $response = $this->json('POST', '/api/auth/login', $loginData);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'access_token',
                'token_type',
                'expires_in'
            ]);

        return $response->json('access_token');
    }


    

    public function test_register()
    {
        $registerData = [
            'name' => 'test',
            'email' => 'test@test.com',
            'password' => 'test12345'
        ];

        $response = $this->json('POST', '/api/auth/register', $registerData);

        $response->assertStatus(200);
    }

    public function test_login()
    {
        User::create([
            'name' => 'test',
            'email' => 'test@test.com',
            'password' => bcrypt('test12345') // bcrypt untuk mengenkripsi password
        ]);

        $loginData = [
            'email' => 'test@test.com',
            'password' => 'test12345'
        ];

        $response = $this->json('POST', '/api/auth/login', $loginData);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'access_token',
                'token_type',
                'expires_in'
            ]);
    }
}
