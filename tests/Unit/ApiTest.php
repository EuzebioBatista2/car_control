<?php

namespace Tests\Unit;

use App\Http\Controllers\VehiclesDataController;
use PHPUnit\Framework\TestCase;

class ApiTest extends TestCase
{
    /** @test */
    public function check_if_the_brands_and_colors_and_steering_system_and_type_of_fuels_api_is_working(): void
    {
        /* Arrays test */
        $brands_array = ['brand'];
        $colors_array = ['color'];
        $steering_systems_array = ['steering_system'];
        $type_of_fuels_array = ['type_of_fuel'];

        $controller = new VehiclesDataController($brands_array, $colors_array, $steering_systems_array, $type_of_fuels_array);

        $response = $controller->index();

        $expected_array = [
            'brands' => $brands_array,
            'colors' => $colors_array,
            'steering_systems' => $steering_systems_array,
            'type_of_fuels' => $type_of_fuels_array,
        ];

        // Check if the velues is array
        $this->assertIsArray($response, 'The value is not array');

        /* Check if the array is equal the response  */
        $this->assertEquals($expected_array, $response); 

    }

    /** @test */
    public function check_if_the_models_is_working()
    {

        $models_array = ['model'];

        $controller = new VehiclesDataController(null, null, null, null, $models_array);

        $response = $controller->models('');

        $expected_array = [
            'models' => $models_array
        ];

        // Check if the velues is array
        $this->assertIsArray($response, 'The value is not array');

        /* Check if the array is equal the response  */
        $this->assertEquals($expected_array, $response); 

    }
}
