<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class ApiTest extends TestCase
{
    /** @test */
    public function check_if_the_index_page_is_working(): void
    {
        /* Login in */
        $this->post('/login', [
            'email' => 'Teste@teste.com',
            'password' => '123456Teste@'
        ]);

        /* Admin authenticate */
        $this->assertTrue(Auth::check());

        $response = $this->get('/api/vehicles-data');

        $response->assertStatus(200);
    }

    /** @test */
    public function check_if_the_models_page_is_working(): void
    {
        /* Login in */
        $this->post('/login', [
            'email' => 'Teste@teste.com',
            'password' => '123456Teste@'
        ]);

        /* Admin authenticate */
        $this->assertTrue(Auth::check());

        /* Model without brand */
        $response = $this->get('/api/models');
        $response->assertStatus(200);

        /* Model with brand */
        $response = $this->get('/api/models/Fiat');
        $response->assertStatus(200);
    }
}
