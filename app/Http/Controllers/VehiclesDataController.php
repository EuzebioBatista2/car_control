<?php

namespace App\Http\Controllers;
use App\Models\Brands;
use App\Models\Colors;
use App\Models\Models;
use App\Models\SteeringSystem;
use App\Models\TypeOfFuel;

class VehiclesDataController extends Controller
{
    //
    public function index()
    {
        $brands = Brands::select('brand')->pluck('brand')->toArray();
        $content_vehicles['brands'] = $brands;

        $colors = Colors::select('color')->pluck('color')->toArray();
        $content_vehicles['colors'] = $colors;

        $steering_system = SteeringSystem::select('steering_system')->pluck('steering_system')->toArray();
        $content_vehicles['steering_systems'] = $steering_system;

        $type_of_fuel = TypeOfFuel::select('type_of_fuel')->pluck('type_of_fuel')->toArray();
        $content_vehicles['type_of_fuels'] = $type_of_fuel;

        return response()->json($content_vehicles);
    }

    public function models($brand = '')
    {
        $brand_id = Brands::select('id')->where('brand', $brand)->first();
        $content_brands = [];
        if($brand_id) {
            $models = Models::select('model')->where('brand_id', $brand_id['id'])->pluck('model')->toArray();
            $content_brands['models'] = $models;
        }
        return response()->json($content_brands);
    }
}
