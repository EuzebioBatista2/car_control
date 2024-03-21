<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class WelcomeTest extends TestCase
{
    /** @test */
    public function check_if_the_index_page_is_working_without_login(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    /** @test */
    public function check_if_the_index_page_is_working_with_login(): void
    {
        /* Login in */
        $this->post('/login', [
            'email' => 'Teste@teste.com',
            'password' => '123456Teste@'
        ]);

        /* Admin authenticate */
        $this->assertTrue(Auth::check());

        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
