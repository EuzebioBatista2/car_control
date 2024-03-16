<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class RegisterAndDeleteAdminTest extends DuskTestCase
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
    public function check_if_register_function_is_working()
    {
        $this->browse(function (Browser $browser) {
            // Visita a página de registro
            $browser->visit('/register')
                ->type('name', 'John')
                ->type('lastname', 'Doe')
                ->type('email', 'Teste1@teste.com')
                ->type('password', '123456Teste@')
                ->type('password_confirmation', '123456Teste@')
                ->press('Registrar')
                ->assertPathIs('/dashboard');
        });
    }

    /**  @test */
    public function check_if_register_is_deleted()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/account')
                ->press('Deletar conta')
                ->acceptDialog()
                ->assertPathIs('/login');
        });
    }
}
