<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class RegisterUserTest extends DuskTestCase
{
    /**  @test */
    public function check_if_root_site_is_correct(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                    ->assertSee('CONHEÇA MAIS SOBRE')
                    ->assertSee('NOSSAS FUNÇÕES');
        });
    }

    /**  @test */
    public function check_if_login_function_is_not_working()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                ->type('email', 'Teste@teste.com')
                ->type('password', '123456')
                ->press('Logar')
                ->assertPathIs('/login');
        });
    }

    /**  @test */
    public function check_if_login_function_is_working()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                ->type('email', 'Teste@teste.com')
                ->type('password', '123456Teste@')
                ->press('Logar')
                ->assertPathIs('/dashboard');
        });
    }
}
