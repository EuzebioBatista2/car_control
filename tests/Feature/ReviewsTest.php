<?php

namespace Tests\Feature;

use App\Http\Controllers\ReviewsController;
use App\Models\Reviews;
use App\Models\Vehicles;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;


class ReviewsTest extends TestCase
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

        $response = $this->get('/reviews');

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

        $vehicle = Vehicles::factory()->create();

        $response = $this->get("/reviews/$vehicle->id");

        $response->assertStatus(200);
    }

    /** @test */
    public function check_if_the_index_owner_page_is_working_with_value_not_integer_or_id_wrong(): void
    {
        /* Login in */
        $this->post('/login', [
            'email' => 'Teste@teste.com',
            'password' => '123456Teste@'
        ]);

        /* Admin authenticate */
        $this->assertTrue(Auth::check());

        $response = $this->get("/reviews/test");

        $response->assertStatus(302)
            ->assertRedirect('/reviews');

        $response = $this->get("/reviews/99999999");

        $response->assertStatus(200);
    }

    /** @test */
    public function check_if_the_validates_is_working()
    {
        $validator = $this->app->make(ReviewsController::class)->validator([]);

        /* Validate errors */
        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('problems', $validator->errors()->toArray());
    }

    /** @test */
    public function check_if_create_function_on_reviews_page_is_working()
    {

        /* Login in */
        $this->post('/login', [
            'email' => 'Teste@teste.com',
            'password' => '123456Teste@'
        ]);

        $vehicle = Vehicles::factory()->create();

        $vehicle_data = [
            'vehicle_id' => $vehicle->id,
            'problems' => 'Test problem',
            'date_review' => date('Y-m-d H:i:s'),
            'completed' => '0',
        ];

        /* Create vehicle */
        $response = $this->post("/reviews/$vehicle->id", $vehicle_data);

        $response->assertStatus(302)
            ->assertRedirect("/reviews/$vehicle->id");
    }

    /** @test */
    public function check_if_edit_function_on_reviews_page_id_working()
    {
        /* Login in */
        $this->post('/login', [
            'email' => 'Teste@teste.com',
            'password' => '123456Teste@'
        ]);

        $review = Reviews::factory()->create();

        $response = $this->get("/reviews/$review->vehicle_id/$review->id");
        $response->assertStatus(200);
    }

    /** @test */
    public function check_if_edit_function_on_reviews_page_id_working_with_value_not_integer_and_id_wrong()
    {
        /* Login in */
        $this->post('/login', [
            'email' => 'Teste@teste.com',
            'password' => '123456Teste@'
        ]);

        $review = Reviews::factory()->create();

        /* Wrong Vehicle ID */
        $response = $this->get("/reviews/99999999/$review->id");
        $response->assertStatus(200);

        /* String Vehicle ID */
        $response = $this->get("/reviews/test/$review->id");
        $response->assertStatus(302)
            ->assertRedirect("/reviews");

        /* Wrong Review ID */
        $response = $this->get("/reviews/$review->vehicle_id/9999999");
        $response->assertStatus(200);

        /* String Reviews ID */
        $response = $this->get("/reviews/$review->vehicle_id/test");
        $response->assertStatus(302)
            ->assertRedirect("/reviews/$review->vehicle_id");
    }

    /** @test */
    public function check_if_the_update_function_on_reviews_page_is_working()
    {
        /* Login in */
        $this->post('/login', [
            'email' => 'Teste@teste.com',
            'password' => '123456Teste@'
        ]);

        $review = Reviews::factory()->create();

        $vehicle_data = [
            'vehicle_id' => $review->vehicle_id,
            'problems' => 'New test problem',
            'date_review' => date('Y-m-d H:i:s'),
            'completed' => '1',
        ];

        /* Create customer */
        $response = $this->put("/reviews/$review->vehicle_id/$review->id", $vehicle_data);

        $response->assertStatus(302)
            ->assertRedirect("/reviews/$review->vehicle_id");
    }

    /** @test */
    public function check_if_the_delete_function_is_working()
    {
        $this->post('/login', [
            'email' => 'Teste@teste.com',
            'password' => '123456Teste@'
        ]);

        $review = Reviews::factory()->create();

        $response = $this->delete("/reviews/$review->vehicle_id/$review->id");

        $response->assertStatus(302)
            ->assertRedirect("/reviews/$review->vehicle_id");
    }

    /** @test */
    public function check_if_the_search_function_is_working()
    {
        $this->post('/login', [
            'email' => 'Teste@teste.com',
            'password' => '123456Teste@'
        ]);

        $search_by_name = [
            'select' => 'name',
            'data' => 'a'
        ];

        $search_by_brand = [
            'select' => 'brand',
            'data' => 'a'
        ];

        $search_by_problem = [
            'select' => 'problems',
            'data' => 'a'
        ];

        $search_by_wrong_column = [
            'select' => 'test',
            'data' => 'a'
        ];

        /* Search by the name */
        $response = $this->get("/reviews/search?" . http_build_query($search_by_name));
        $response->assertStatus(200);

        /* Search by the brand, model, year and color */
        $response = $this->get("/reviews/search?" . http_build_query($search_by_brand));
        $response->assertStatus(200);

        /* Search by the problem */
        $response = $this->get("/reviews/search?" . http_build_query($search_by_problem));
        $response->assertStatus(200);

        /* Search by the wrong column */
        $response = $this->get("/reviews/search?" . http_build_query($search_by_wrong_column));
        $response->assertStatus(200);
    }

    /** @test */
    public function check_if_the_search_owner_function_is_working()
    {
        $this->post('/login', [
            'email' => 'Teste@teste.com',
            'password' => '123456Teste@'
        ]);

        $search_date = [
            'initial_date' => '',
            'final_date' => '2024-03-20T00:17'
        ];

        $search_both_date = [
            'initial_date' => '2024-03-20T00:10',
            'final_date' => '2024-03-20T00:17'
        ];

        $review = Reviews::factory()->create();

        /* Only final_date */
        $response = $this->get("/reviews/search_owner/$review->vehicle_id?" . http_build_query($search_date));
        $response->assertStatus(200);

        /* Both dates */
        $response = $this->get("/reviews/search_owner/$review->vehicle_id?" . http_build_query($search_both_date));
        $response->assertStatus(200);
    }

    /** @test */
    public function check_if_the_search_owner_function_is_working_with_value_is_not_date_and_date_wrong()
    {
        $this->post('/login', [
            'email' => 'Teste@teste.com',
            'password' => '123456Teste@'
        ]);

        $search_date = [
            'initial_date' => '',
            'final_date' => '2024-03-20T00:17'
        ];

        $wrong_search_date = [
            'initial_date' => 'test',
            'final_date' => 'test'
        ];

        $review = Reviews::factory()->create();

        /* Id wrong */
        $response = $this->get("/reviews/search_owner/9999999?" . http_build_query($search_date));
        $response->assertStatus(200);

        /* Id isn't integer */
        $response = $this->get("/reviews/search_owner/test?" . http_build_query($search_date));
        $response->assertStatus(302)
            ->assertRedirect("/reviews");
        
        /* Date wrong */
        $response = $this->get("/reviews/search_owner/$review->vehicle_id?" . http_build_query($wrong_search_date));
        $response->assertStatus(200);
    }
}
