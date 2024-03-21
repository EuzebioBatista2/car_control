<?php

namespace Tests\Feature;

use App\Http\Controllers\CustomersController;
use App\Models\Customers;
use Illuminate\Support\Facades\Auth;
use Faker\Factory as Faker;

use Tests\TestCase;

class CustomersTest extends TestCase
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

        $response = $this->get('/customers');

        $response->assertStatus(200);
    }

    /** @test */
    public function check_if_the_validates_is_working()
    {
        $validator = $this->app->make(CustomersController::class)->validator([]);

        /* Validate errors */
        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('name', $validator->errors()->toArray());
        $this->assertArrayHasKey('lastname', $validator->errors()->toArray());
        $this->assertArrayHasKey('email', $validator->errors()->toArray());
        $this->assertArrayHasKey('phone', $validator->errors()->toArray());
        $this->assertArrayHasKey('age', $validator->errors()->toArray());
        $this->assertArrayHasKey('gender', $validator->errors()->toArray());
    }

    /** @test */
    public function check_if_create_function_on_customers_page_is_working()
    {

        /* Login in */
        $this->post('/login', [
            'email' => 'Teste@teste.com',
            'password' => '123456Teste@'
        ]);

        $userId = auth()->id();

        $faker = Faker::create();

        $customer_data = [
            'name' => 'Teste',
            'lastname' => 'Case',
            'email' => $faker->unique()->safeEmail,
            'phone' => '(99) 99999-9999',
            'age' => 25,
            'gender' => 'M',
            'admin_id' => $userId
        ];

        /* Create customer */
        $response = $this->post('/customers',$customer_data);

        $response->assertStatus(302)
            ->assertRedirect('/customers'); 
    }

    /** @test */
    public function check_if_edit_function_on_customers_page_id_working()
    {
        /* Login in */
        $this->post('/login', [
            'email' => 'Teste@teste.com',
            'password' => '123456Teste@'
        ]);

        $customer = Customers::factory()->create();

        /* Correct Id */
        $response = $this->get("/customers/$customer->id");
        $response->assertStatus(200);

        /* Wrong Id */
        $response = $this->get("/customers/999999");
        $response->assertStatus(200);

        /* String Id */
        $response = $this->get("/customers/test");
        $response->assertStatus(302)
        ->assertRedirect('/customers');
    }

    /** @test */
    public function check_if_the_update_function_on_customers_page_is_working()
    {
        /* Login in */
        $this->post('/login', [
            'email' => 'Teste@teste.com',
            'password' => '123456Teste@'
        ]);

        $customer = Customers::factory()->create();

        $customer_data = [
            'name' => 'New',
            'lastname' => 'Test Case',
            'email' => $customer->email,
            'phone' => '(99) 99999-9999',
            'age' => 25,
            'gender' => 'F',
        ];

        /* Create customer */
        $response = $this->put("/customers/$customer->id",$customer_data);

        $response->assertStatus(302)
            ->assertRedirect('/customers'); 
    }

    /** @test */
    public function check_if_the_delete_function_is_working()
    {
        $this->post('/login', [
            'email' => 'Teste@teste.com',
            'password' => '123456Teste@'
        ]);

        $customer = Customers::factory()->create();

        $response = $this->delete("/customers/$customer->id");

        $response->assertStatus(302)
            ->assertRedirect('/customers'); 
    }

    /** @test */
    public function check_if_the_search_function_is_working()
    {
        $this->post('/login', [
            'email' => 'Teste@teste.com',
            'password' => '123456Teste@'
        ]);

        $search_data = [
            'select' => 'name',
            'data' => 'a'
        ];

        $wrong_search_data = [
            'select' => 'test',
            'data' => 'a'
        ];

        /* Currect column */
        $response = $this->get("/customers/search?" . http_build_query($search_data) );
        $response->assertStatus(200);

        /* Wrong column */
        $response = $this->get("/customers/search?" . http_build_query($wrong_search_data) );
        $response->assertStatus(200);
    }
    
}
