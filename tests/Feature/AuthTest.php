<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_puede_mandar_error_credenciales()
    {
        User::factory()->create([
            'name' => 'Vanic',
            'email' => 'vanic@gmail.com',
            'password' => '12345678'
        ]);

        $response = $this->post('/api/auth/login', [
            'email' => 'vanic@gmail.com',
            'password' => '123456789'
        ]);

        $response->assertStatus(404);
    }

    public function test_puede_iniciar_sesion()
    {
        User::factory()->create([
            'name' => 'Vanic',
            'email' => 'vanic@gmail.com',
            'password' => '12345678'
        ]);

        $response = $this->post('/api/auth/login', [
            'email' => 'vanic@gmail.com',
            'password' => '12345678'
        ]);

        $response->assertStatus(200);
    }
}
