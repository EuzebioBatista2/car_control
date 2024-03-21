<?php

namespace App\Http\Controllers;

use App\Models\Customers;
use App\Models\Reviews;
use App\Models\Vehicles;
use Illuminate\Support\Facades\Lang;

class ExcelController extends Controller
{
    /* User ID at login */
    private $auth_user;

    public function __construct()
    {
        $this->auth_user = '';
    }

    /* Initial page */
    public function index()
    {
        $this->auth_user = auth()->user()->id;

        /* Query the last twenty customers in the table. */
        $customers_table = Customers::where('admin_id', $this->auth_user)
            ->select('name', 'lastname', 'email', 'phone', 'age', 'gender')
            ->orderBy('id', 'asc')->limit(20)->get();

        $customers_columns = [];

        /* Customer(s) exist? */
        if ($customers_table->count() > 0) {
            /* Get the columns in the table */
            $customers_columns = array_keys($customers_table->first()->getAttributes());

            foreach ($customers_columns as $key => $column) {
                $translated_column = Lang::get("messages.$column");
                if ($translated_column !== "messages.$column") {
                    /* If the traduce exists, replace the column name with formatted name. */
                    $customers_columns[$key] = ucfirst($translated_column);
                } else {
                    /* If the traduce don't exists, capitalize the first letter of the word. */
                    $customers_columns[$key] = ucfirst($column);
                }
            }
        }

        /* Query the last twenty vehicles in the table. */
        $vehicles_table = Vehicles::select('customers.name', 'vehicles.brand', 'vehicles.plate', 'vehicles.model', 'vehicles.year', 'vehicles.color', 'vehicles.steering_system', 'vehicles.type_of_fuel')
            ->leftJoin('customers', 'vehicles.customer_id', '=', 'customers.id')
            ->leftJoin('admins', 'customers.admin_id', '=', "admins.id")
            ->where('customers.admin_id', "$this->auth_user")
            ->orderBy('name', 'asc')->limit(20)->get();

        $vehicles_columns = [];

        /* Vehicles exist? */
        if ($vehicles_table->count() > 0) {
            /* Get the columns in the table */
            $vehicles_columns = array_keys($vehicles_table->first()->getAttributes());

            foreach ($vehicles_columns as $key => $column) {
                $translated_column = Lang::get("messages.$column");
                if ($translated_column !== "messages.$column") {
                    /* If the traduce exists, replace the column name with formatted name. */
                    $vehicles_columns[$key] = ucfirst($translated_column);
                } 
            }
        }

        /* Query the last twenty reviews in the table. */
        $reviews_table = Reviews::select('customers.name', 'vehicles.brand', 'vehicles.model', 'vehicles.year', 'reviews.date_review', 'reviews.problems', 'reviews.completed')
            ->leftJoin('vehicles', 'reviews.vehicle_id', '=', "vehicles.id")
            ->leftJoin('customers', 'vehicles.customer_id', '=', 'customers.id')
            ->leftJoin('admins', 'customers.admin_id', '=', "admins.id")
            ->where('customers.admin_id', "$this->auth_user")
            ->orderBy('name', 'asc')->limit(20)->get();

        $reviews_columns = [];

        /* Reviews exist? */
        if ($reviews_table->count() > 0) {
            /* Get the columns in the table */
            $reviews_columns = array_keys($reviews_table->first()->getAttributes());

            foreach ($reviews_columns as $key => $column) {
                $translated_column = Lang::get("messages.$column");
                if ($translated_column !== "messages.$column") {
                    /* If the traduce exists, replace the column name with formatted name. */
                    $reviews_columns[$key] = ucfirst($translated_column);
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
