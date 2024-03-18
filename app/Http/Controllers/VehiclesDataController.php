<?php

namespace App\Http\Controllers;
use App\Models\Brands;
use App\Models\Colors;
use App\Models\Models;
use App\Models\SteeringSystem;
use App\Models\TypeOfFuel;

class VehiclesDataController extends Controller
{
    protected Array|null $brands;
    protected Array|null $colors;
    protected Array|null $steering_systems;
    protected Array|null $type_of_fuels;
    protected Array|null $models;

    public function __construct($brands = null, $colors = null, $steering_systems = null, $type_of_fuels = null, $models = null)
    {
        $this->brands = $brands;
        $this->colors = $colors;
        $this->steering_systems = $steering_systems;
        $this->type_of_fuels = $type_of_fuels;
        $this->models = $models;
    }
    /* Initial API */
    public function index()
    {
        $brands = $this->get_brands();
        $content_vehicles['brands'] = $brands;

        $colors = $this->get_colors();
        $content_vehicles['colors'] = $colors;

        $steering_system = $this->get_steering_systems();
        $content_vehicles['steering_systems'] = $steering_system;

        $type_of_fuel = $this->get_type_of_fuels();
        $content_vehicles['type_of_fuels'] = $type_of_fuel;

        /* Selecting data */
        return $content_vehicles;
    }

    public function models($brand = '')
    {
        $models = $this->get_models();

        if($models === null)
        {
            $brand_id = Brands::select('id')->where('brand', $brand)->first();
            if($brand_id) {
                $this->set_models($brand_id);
            }
        }
        $content_brands = [];
        $content_brands['models'] = $this->get_models();

        /* Relationship with selected input. */
        return $content_brands;
    }

    public function get_brands()
    {
        if($this->brands === null)
        {
            return $this->brands = Brands::select('brand')->pluck('brand')->toArray();
        }
        return $this->brands;
    }

    public function get_colors()
    {
        if($this->colors === null)
        {
            return $this->colors = Colors::select('color')->pluck('color')->toArray();
        }
        return $this->colors;
    }

    public function get_steering_systems()
    {
        if($this->steering_systems === null)
        {
            return $this->steering_systems = SteeringSystem::select('steering_system')->pluck('steering_system')->toArray();
        }
        return $this->steering_systems;
    }

    public function get_type_of_fuels()
    {
        if($this->type_of_fuels === null)
        {
            return $this->type_of_fuels = TypeOfFuel::select('type_of_fuel')->pluck('type_of_fuel')->toArray();
        }
        return $this->type_of_fuels;
    }

    public function get_models()
    {
        return $this->models;
    }

    public function set_models($brand_id)
    {
        $this->models = Models::select('model')->where('brand_id', $brand_id['id'])->pluck('model')->toArray();
    }
}
