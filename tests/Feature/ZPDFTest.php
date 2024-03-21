<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class ZPDFTest extends TestCase
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

        $response = $this->get('/pdf');

        $response->assertStatus(200);
    }
}
