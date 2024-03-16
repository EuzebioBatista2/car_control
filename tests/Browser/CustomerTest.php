<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class CustomerTest extends DuskTestCase
{

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

    /**  @test */
    public function check_if_register_in_customers_page_working()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/customers')
                ->click('#modal-button')
                ->waitFor('#add-modal')
                ->within('#add-modal', function ($browser) {
                    $browser->type('name', 'Maria')
                        ->type('lastname', 'Carla')
                        ->type('email', 'Maria@teste.com')
                        ->type('phone', '(99) 99999-9999')
                        ->type('age', 25)
                        ->select('gender', 'F');
                })
                ->press('Criar')
                ->assertPathIs('/customers');
        });
    }

    /**  @test */
    public function check_if_edit_customer_is_working()
    {
        $this->browse(function(Browser $browser) {
            $browser->visit('/customers')
                ->click('#button-edit')
                ->waitFor('#name')
                ->type('name', 'Joana')
                ->press('Atualizar')
                ->assertPathIs('/customers');
        });
    }

    /**  @test */
    public function check_if_its_possible_to_delete_customers()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/customers')
                ->click('#button-delete')
                ->acceptDialog()
                ->assertPathIs('/customers');
        });
    }
}
