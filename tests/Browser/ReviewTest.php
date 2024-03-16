<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class ReviewTest extends DuskTestCase
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
                ->waitFor('#modal-button')
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
    public function check_if_register_in_vehicles_page_working()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/customers')
                ->waitFor('#vehicle-button')
                ->click('#vehicle-button')
                ->waitFor('#modal-button')
                ->click('#modal-button')
                ->waitFor('#add-modal')
                ->within('#add-modal', function ($browser) {
                    $browser->type('plate', 'ABC-1234')
                        ->select('brand', 'Chevrolet')
                        ->waitFor('#model')
                        ->select('model', 'Onix')
                        ->type('year', 2015)
                        ->select('color', 'Preto')
                        ->radio('steering_system', 'Direção hidráulica')
                        ->radio('type_of_fuel', 'Gasolina');
                })
                ->press('Criar');
        });
    }

    /**  @test */
    public function check_if_register_in_reviews_page_working()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/customers')
                ->waitFor('#vehicle-button')
                ->click('#vehicle-button')
                ->waitFor('#review-button')
                ->click('#review-button')
                ->waitFor('#modal-button')
                ->click('#modal-button')
                ->waitFor('#add-modal')
                ->within('#add-modal', function ($browser) {
                    $browser->waitFor('#problems')
                        ->type('problems', 'Informando problema teste');
                })
                ->press('Criar');
        });
    }

    /**  @test */
    public function check_if_edit_review_is_working()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/customers')
                ->waitFor('#vehicle-button')
                ->click('#vehicle-button')
                ->waitFor('#review-button')
                ->click('#review-button')
                ->waitFor('#button-edit')
                ->click('#button-edit')
                ->waitFor('#problems')
                ->type('problems', 'Informando novo problema de teste')
                ->press('Atualizar');
        });
    }

    /**  @test */
    public function check_if_its_possible_to_delete_reviews()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/customers')
                ->waitFor('#vehicle-button')
                ->click('#vehicle-button')
                ->waitFor('#review-button')
                ->click('#review-button')
                ->waitFor('#button-delete')
                ->click('#button-delete')
                ->acceptDialog();
        });
    }

    /**  @test */
    public function check_if_its_possible_to_delete_vehicles()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/customers')
                ->click('#vehicle-button')
                ->waitFor('#button-delete')
                ->click('#button-delete')
                ->acceptDialog();
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
