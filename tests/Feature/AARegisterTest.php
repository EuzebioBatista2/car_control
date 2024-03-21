<?php

namespace Tests\Feature;

use App\Http\Controllers\Auth\RegisterController;
use Tests\TestCase;

class AARegisterTest extends TestCase
{
    /** @test */
    public function check_if_the_Register_page_is_working(): void
    {
        /* Login in */
        $response = $this->GET('/register');

        $response->assertStatus(200); 
    }

    /** @test */
    public function check_if_the_validates_is_working()
    {
        $validator = $this->app->make(RegisterController::class)->validator([
            'name' => '',
            'lastname' => '',
            'email' => 'test',
            'password' => '',
        ]);

        /* Validate errors */
        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('name', $validator->errors()->toArray());
        $this->assertArrayHasKey('lastname', $validator->errors()->toArray());
        $this->assertArrayHasKey('email', $validator->errors()->toArray());
        $this->assertArrayHasKey('password', $validator->errors()->toArray());
    }

    /** @test */
    public function check_if_create_function_on_register_page_is_working()
    {
        $admin_data = [
            'name' => 'Teste',
            'lastname' => 'Case',
            'email' => 'Teste@teste.com',
            'password' => '123456Teste@',
            'password_confirmation' => '123456Teste@',
        ];

        /* Create customer */
        $response = $this->post('/register',$admin_data);

        $response->assertStatus(302)
            ->assertRedirect('/dashboard'); 
    }
}
