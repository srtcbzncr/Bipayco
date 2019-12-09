<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginTest extends TestCase
{
    public function testGet(){
        $response = $this->get('/login');

        $response->assertOk();
        $response->assertViewIs('auth.login');
    }
}
