<?php

namespace Tests\Feature;

use App\Http\Controllers\VehiclesController;
use Illuminate\Support\Facades\Auth;
use App\Models\Customers;
use App\Models\Vehicles;
use Tests\TestCase;
use Faker\Factory as Faker;

class VehiclesTest extends TestCase
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

        $response = $this->get('/vehicles');

        $response->assertStatus(200);
    }

    /** @test */
    public function check_if_the_index_owner_page_is_working(): void
    {
        /* Login in */
        $this->post('/login', [
            'email' => 'Teste@teste.com',
            'password' => '123456Teste@'
        ]);

        /* Admin authenticate */
        $this->assertTrue(Auth::check());

        $customer = Customers::factory()->create();

        /* Correct ID */
        $response = $this->get("/vehicles/$customer->id");
        $response->assertStatus(200);

        /* Wrong ID */
        $response = $this->get("/vehicles/999999999");
        $response->assertStatus(200);

        /* String ID */
        $response = $this->get("/vehicles/test");
        $response->assertStatus(302)
            ->assertRedirect("/vehicles");
    }

    /** @test */
    public function check_if_the_validates_is_working()
    {
        $validator = $this->app->make(VehiclesController::class)->validator([]);

        /* Validate errors */
        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('plate', $validator->errors()->toArray());
        $this->assertArrayHasKey('brand', $validator->errors()->toArray());
        $this->assertArrayHasKey('model', $validator->errors()->toArray());
        $this->assertArrayHasKey('year', $validator->errors()->toArray());
        $this->assertArrayHasKey('color', $validator->errors()->toArray());
        $this->assertArrayHasKey('steering_system', $validator->errors()->toArray());
        $this->assertArrayHasKey('type_of_fuel', $validator->errors()->toArray());
    }

    /** @test */
    public function check_if_create_function_on_vehicles_page_is_working()
    {

        /* Login in */
        $this->post('/login', [
            'email' => 'Teste@teste.com',
            'password' => '123456Teste@'
        ]);

        $customer = Customers::factory()->create();

        $faker = Faker::create();

        $vehicle_data = [
            'plate' => 'ABC-1234',
            'brand' => 'Fiat',
            'model' => 'Uno',
            'year' => $faker->numberBetween(1950, 2024),
            'color' => 'Preto',
            'steering_system' => 'Direção hidráulica',
            'type_of_fuel' => 'Gasolina',
            'customer_id' => $customer->id
        ];

        /* Create vehicle */
        $response = $this->post("/vehicles/$customer->id", $vehicle_data);

        $response->assertStatus(302)
            ->assertRedirect("/vehicles/$customer->id");
    }

    /** @test */
    public function check_if_edit_function_on_vehicles_page_id_working()
    {
        /* Login in */
        $this->post('/login', [
            'email' => 'Teste@teste.com',
            'password' => '123456Teste@'
        ]);

        $vehicle = Vehicles::factory()->create();

        /* Correct IDs */
        $response = $this->get("/vehicles/$vehicle->customer_id/$vehicle->id");
        $response->assertStatus(200);

        /* Wrong Customer_id */
        $response = $this->get("/vehicles/9999999999/$vehicle->id");
        $response->assertStatus(200);

        /* String Customer_id */
        $response = $this->get("/vehicles/test/$vehicle->id");
        $response->assertStatus(302)
            ->assertRedirect("/vehicles");

        /* Wrong Vehicle_id */
        $response = $this->get("/vehicles/$vehicle->customer_id/99999999");
        $response->assertStatus(200);

        /* String Vehicle_id */
        $response = $this->get("/vehicles/$vehicle->customer_id/test");
        $response->assertStatus(302)
            ->assertRedirect("/vehicles/$vehicle->customer_id");
    }

    /** @test */
    public function check_if_the_update_function_on_vehicle_page_is_working()
    {
        /* Login in */
        $this->post('/login', [
            'email' => 'Teste@teste.com',
            'password' => '123456Teste@'
        ]);

        $vehicle = Vehicles::factory()->create();

        $faker = Faker::create();

        $vehicle_data = [
            'plate' => 'ABC-1234',
            'brand' => 'Fiat',
            'model' => 'Prisma',
            'year' => $faker->numberBetween(1950, 2024),
            'color' => 'Preto',
            'steering_system' => 'Direção hidráulica',
            'type_of_fuel' => 'Gasolina',
            'customer_id' => $vehicle->customer_id
        ];

        /* Create customer */
        $response = $this->put("/vehicles/$vehicle->customer_id/$vehicle->id", $vehicle_data);

        $response->assertStatus(302)
            ->assertRedirect("/vehicles/$vehicle->customer_id");
    }

    /** @test */
    public function check_if_the_delete_function_is_working()
    {
        $this->post('/login', [
            'email' => 'Teste@teste.com',
            'password' => '123456Teste@'
        ]);

        $vehicle = Vehicles::factory()->create();

        $response = $this->delete("/vehicles/$vehicle->customer_id/$vehicle->id");

        $response->assertStatus(302)
            ->assertRedirect("/vehicles/$vehicle->customer_id");
    }

    /** @test */
    public function check_if_the_search_function_is_working()
    {
        $this->post('/login', [
            'email' => 'Teste@teste.com',
            'password' => '123456Teste@'
        ]);

        $search_data = [
            'select' => 'brand',
            'data' => 'c'
        ];

        $wrong_search_data = [
            'select' => 'test',
            'data' => 'c'
        ];

        /* Correct search */
        $response = $this->get("/vehicles/search?" . http_build_query($search_data));
        $response->assertStatus(200);

        /* Correct search with wrong select */
        $response = $this->get("/vehicles/search?" . http_build_query($wrong_search_data));
        $response->assertStatus(200);
    }

    /** @test */
    public function check_if_the_search_owner_function_is_working()
    {
        $this->post('/login', [
            'email' => 'Teste@teste.com',
            'password' => '123456Teste@'
        ]);

        $search_data = [
            'select' => 'brand',
            'data' => 'c'
        ];

        $wrong_search_data = [
            'select' => 'test',
            'data' => 'c'
        ];

        $vehicle = Vehicles::factory()->create();

        /* Correct search */
        $response = $this->get("/vehicles/search_owner/$vehicle->customer_id?" . http_build_query($search_data));
        $response->assertStatus(200);

        /* Correct search with wrong select */
        $response = $this->get("/vehicles/search_owner/$vehicle->customer_id?" . http_build_query($wrong_search_data));
        $response->assertStatus(200);

        /* Correct search with wrong id */
        $response = $this->get("/vehicles/search_owner/999999?" . http_build_query($search_data));
        $response->assertStatus(200);

        /* Correct search with string id */
        $response = $this->get("/vehicles/search_owner/test?" . http_build_query($search_data));
        $response->assertStatus(302)
            ->assertRedirect("/vehicles");
    }
}
