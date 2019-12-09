<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;
use App\Models\Auth\User;

class RegisterTest extends TestCase
{
    use WithFaker;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testPost()
    {
        // Data preparation
        $data = [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'username' => $this->faker->userName,
            'password' => $this->faker->password,
            'email' => $this->faker->email,
            'phone' => $this->faker->e164PhoneNumber,
            'district_id' => 1,
            ];

        // Operations
        $response = $this->post('/register', $data);

        // Control
        $user = User::where(['email' => $data['email'], 'username' => $data['username']])->first();
        $response->assertOk();
        $response->assertLocation('/');
        $this->assertNotNull($user);
    }

    public function testGet(){
        $response = $this->get('/register');

        $response->assertOk();
        $response->assertViewIs('auth.register');
    }
}
