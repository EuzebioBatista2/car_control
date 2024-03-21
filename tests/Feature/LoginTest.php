<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class LoginTest extends TestCase
{
    /** @test */
    public function check_if_the_Login_page_is_working(): void
    {
        /* Login in */
        $response = $this->post('/login', [
            'email' => 'Teste@teste.com',
            'password' => '123456Teste@'
        ]);

        /* Admin authenticate */
        $this->assertTrue(Auth::check());

        $response->assertStatus(302)
            ->assertRedirect('/dashboard'); 
    }

    /** @test */
    public function check_if_the_Login_page_is_working_with_wrong_data(): void
    {
        /* Login in */
        $response = $this->post('/logout', [
            'email' => 'WrongTeste@teste.com',
            'password' => '123456WrongTeste@'
        ]);

        /* Admin authenticate */
        $this->assertFalse(Auth::check());

        $response->assertStatus(302)
            ->assertRedirect('/');
    }

    /** @test */
    public function check_if_the_Logout_page_is_working(): void
    {
        /* Login in */
        $response = $this->post('/logout', [
            'email' => 'WrongTeste@teste.com',
            'password' => '123456WrongTeste@'
        ]);

        /* Login in */
        $response = $this->post('/logout');

        /* Admin authenticate */
        $this->assertFalse(Auth::check());

        $response->assertStatus(302)
            ->assertRedirect('/'); 
    }
}
