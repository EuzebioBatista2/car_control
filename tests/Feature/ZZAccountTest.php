<?php

namespace Tests\Feature;

use App\Http\Controllers\AccountController;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class ZZAccountTest extends TestCase
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

        $response = $this->get('/account');

        $response->assertStatus(200);
    }

    /** @test */
    public function check_if_the_validates_information_is_working()
    {
        /* Login in */
        $this->post('/login', [
            'email' => 'Teste@teste.com',
            'password' => '123456Teste@'
        ]);

        /* Admin authenticate */
        $this->assertTrue(Auth::check());

        $validator = $this->app->make(AccountController::class)->validator_informations([
            'name' => '',
            'lastname' => '',
            'email' => ''
        ]);

        /* Validate errors */
        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('name', $validator->errors()->toArray());
        $this->assertArrayHasKey('lastname', $validator->errors()->toArray());
        $this->assertArrayHasKey('email', $validator->errors()->toArray());
    }

    /** @test */
    public function check_if_the_validator_password_is_working()
    {
        /* Login in */
        $this->post('/login', [
            'email' => 'Teste@teste.com',
            'password' => '123456Teste@'
        ]);

        /* Admin authenticate */
        $this->assertTrue(Auth::check());

        $validator = $this->app->make(AccountController::class)->validator_password([
            'current_password' => 'test',
            'password' => ''
        ]);

        /* Validate errors */
        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('current_password', $validator->errors()->toArray());
        $this->assertArrayHasKey('password', $validator->errors()->toArray());
    }

    /** @test */
    public function check_if_the_update_information_on_account_page_is_working()
    {
        /* Login in */
        $this->post('/login', [
            'email' => 'Teste@teste.com',
            'password' => '123456Teste@'
        ]);


        $informations_data = [
            'name' => 'New',
            'lastname' => 'Test Case',
            'email' => 'Teste@teste.com',
        ];

        /* Update content with new informations */
        $response = $this->put("/account/informations",$informations_data);
        $response->assertStatus(302)
            ->assertRedirect('/account'); 

        /* Update content with information already used */
        $response = $this->put("/account/informations",$informations_data);
        $response->assertStatus(302)
            ->assertRedirect('/account'); 
    }

    /** @test */
    public function check_if_the_update_password_on_account_page_is_working()
    {
        /* Login in */
        $this->post('/login', [
            'email' => 'Teste@teste.com',
            'password' => '123456Teste@'
        ]);


        $password_data = [
            'current_password' => '123456Teste@',
            'password' => '123456Teste@1',
            'password_confirmation' => '123456Teste@1',
        ];

        $same_password_data = [
            'current_password' => '123456Teste@1',
            'password' => '123456Teste@1',
            'password_confirmation' => '123456Teste@1',
        ];

        /* Update content with new password */
        $response = $this->put("/account/password",$password_data);
        $response->assertStatus(302)
            ->assertRedirect('/account'); 

        /* Update content with information already used */
        $response = $this->put("/account/password",$same_password_data);
        $response->assertStatus(302)
            ->assertRedirect('/account'); 
    }

    /** @test */
    public function check_if_the_delete_user_on_account_page_is_working()
    {
        /* Login in */
        $this->post('/login', [
            'email' => 'Teste@teste.com',
            'password' => '123456Teste@1'
        ]);

        /* Delete account */
        $response = $this->delete("/account/delete");
        $response->assertStatus(302)
            ->assertRedirect('/login'); 
    }


}
