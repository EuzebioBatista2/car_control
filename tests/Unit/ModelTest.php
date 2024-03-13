<?php

namespace Tests\Unit;

use App\Models\Admins;
use App\Models\Customers;
use App\Models\Reviews;
use App\Models\Vehicles;
use PHPUnit\Framework\TestCase;

class ModelTest extends TestCase
{
    /** @test */
    public function check_if_admin_model_is_correct(): void
    {
        $admin = new Admins;

        $expected = [
            'name',
            'lastname',
            'email',
            'password'
        ];

        $array_compared = array_diff($expected, $admin->getFillable());

        $this->assertEquals(0, count($array_compared));
    }

    /** @test */
    public function check_if_customer_model_is_correct(): void
    {
        $customer = new Customers;

        $expected = [
            'name', 
            'lastname', 
            'email', 
            'phone', 
            'age', 
            'gender', 
            'admin_id'
        ];

        $array_compared = array_diff($expected, $customer->getFillable());

        $this->assertEquals(0, count($array_compared));
    }

    /** @test */
    public function check_if_vehicle_model_is_correct(): void
    {
        $vehicle = new Vehicles;

        $expected = [
            'brand', 
            'model', 
            'year', 
            'color', 
            'steering_system', 
            'type_of_fuel', 
            'customer_id'
        ];

        $array_compared = array_diff($expected, $vehicle->getFillable());

        $this->assertEquals(0, count($array_compared));
    }

    /** @test */
    public function check_if_reviews_model_is_correct(): void
    {
        $review = new Reviews;

        $expected = [
            'date_review', 
            'problems', 
            'completed', 
            'vehicle_id'
        ];

        $array_compared = array_diff($expected, $review->getFillable());

        $this->assertEquals(0, count($array_compared));
    }


}
