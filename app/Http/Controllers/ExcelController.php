<?php

namespace App\Http\Controllers;

use App\Models\Customers;
use App\Models\Reviews;
use App\Models\Vehicles;
use Illuminate\Support\Facades\Lang;

class ExcelController extends Controller
{
    //
    public function index()
    {
        $auth_user = auth()->user()->id;

        /* Table customers */
        $customers_table = Customers::where('admin_id', $auth_user)
            ->select('name', 'lastname', 'email', 'phone', 'age', 'gender')
            ->orderBy('id', 'asc')->limit(20)->get();
        $customers_columns = [];

        if ($customers_table->count() > 0) {
            $customers_columns = array_keys($customers_table->first()->getAttributes());

            foreach ($customers_columns as $key => $column) {
                $translated_column = Lang::get("messages.$column");
                if ($translated_column !== "messages.$column") {
                    // Se a tradução existe, substitue a coluna pelo seu equivalente traduzido
                    $customers_columns[$key] = ucfirst($translated_column);
                } else {
                    // Se a tradução não existe, capitaliza a primeira letra e substitua a coluna
                    $customers_columns[$key] = ucfirst($column);
                }
            }
        }

        /* Tavle vehicles */
        $vehicles_table = Vehicles::select('customers.name', 'vehicles.brand', 'vehicles.model', 'vehicles.year', 'vehicles.color', 'vehicles.steering_system', 'vehicles.type_of_fuel')
            ->leftJoin('customers', 'vehicles.customer_id', '=', 'customers.id')
            ->leftJoin('admins', 'customers.admin_id', '=', "admins.id")
            ->where('customers.admin_id', "$auth_user")
            ->orderBy('name', 'asc')->limit(20)->get();
        $vehicles_columns = [];

        if ($vehicles_table->count() > 0) {
            $vehicles_columns = array_keys($vehicles_table->first()->getAttributes());

            foreach ($vehicles_columns as $key => $column) {
                $translated_column = Lang::get("messages.$column");
                if ($translated_column !== "messages.$column") {
                    $vehicles_columns[$key] = ucfirst($translated_column);
                } else {
                    $vehicles_columns[$key] = ucfirst($column);
                }
            }
        }

        /* Table reviews */
        $reviews_table = Reviews::select('customers.name', 'vehicles.brand', 'vehicles.model', 'vehicles.year', 'reviews.date_review', 'reviews.problems', 'reviews.completed')
            ->leftJoin('vehicles', 'reviews.vehicle_id', '=', "vehicles.id")
            ->leftJoin('customers', 'vehicles.customer_id', '=', 'customers.id')
            ->leftJoin('admins', 'customers.admin_id', '=', "admins.id")
            ->where('customers.admin_id', "$auth_user")
            ->orderBy('name', 'asc')->limit(20)->get();

        $reviews_columns = [];

        if ($reviews_table->count() > 0) {
            $reviews_columns = array_keys($reviews_table->first()->getAttributes());

            foreach ($reviews_columns as $key => $column) {
                $translated_column = Lang::get("messages.$column");
                if ($translated_column !== "messages.$column") {
                    $reviews_columns[$key] = ucfirst($translated_column);
                } else {
                    $reviews_columns[$key] = ucfirst($column);
                }
            }
        }

        $data = [
            'customers_table' => $customers_table,
            'customers_columns' => $customers_columns,
            'vehicles_table' => $vehicles_table,
            'vehicles_columns' => $vehicles_columns,
            'reviews_table' => $reviews_table,
            'reviews_columns' => $reviews_columns
        ];

        return view('excel_file', $data);

    }
}
