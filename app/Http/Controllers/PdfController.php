<?php

namespace App\Http\Controllers;

use App\Models\Customers;
use App\Models\Reviews;
use App\Models\Vehicles;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;

class PdfController extends Controller
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

        /* Query the number of the customers. */
        $customers_graph = Customers::select('id')->where('admin_id', $this->auth_user)->count();

        /* Query the number of the vehicles. */
        $vehicles_graph = Vehicles::select('id')
            ->leftJoin('customers', 'vehicles.customer_id', '=', 'customers.id')
            ->where('customers.admin_id', $this->auth_user)->count();

        /* Query the number of the reviews. */
        $reviews_graph = Reviews::select('id')
            ->leftJoin('vehicles', 'reviews.vehicle_id', '=', 'vehicles.id')
            ->leftJoin('customers', 'vehicles.customer_id', '=', 'customers.id')
            ->where('customers.admin_id', $this->auth_user)->count();

        /* Date. */
        $current_date = Carbon::now();

        /* Query the records of the last 7 days. */
        for ($i = 0; $i < 7; $i++) {
            $date = $current_date->clone()->subDays($i)->toDateString();

            /* Return the total records. */
            $total_count = $this->get_total_count_for_date($date);

            $date_formated = date('d-m', strtotime($date));
            $results[] = [
                'date' => $date_formated,
                'total_records' => $total_count
            ];
        }

        $dates = array_reverse($results);

        $labels = [];
        $values = [];

        /* Format the data in the graph */
        foreach ($dates as $item) {
            $labels[] = $item['date'];
            $values[] = $item['total_records'];
        }

        /* Chart template */
        $line_graph = [
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'Registro dos ultimos 7 dias',
                    'data' => $values,
                    'fill' => false,
                    'borderColor' => 'rgb(75, 192, 192)',
                    'lineTension' => 0.1
                ]
            ]
        ];

        /* The number of the genders */
        $genders_values = [];
        $genders = Customers::select(
            DB::raw("SUM(CASE WHEN gender = 'M' THEN 1 ELSE 0 END) AS Masculino"),
            DB::raw("SUM(CASE WHEN gender = 'F' THEN 1 ELSE 0 END) AS Feminino"),
            DB::raw("SUM(CASE WHEN gender = 'N' THEN 1 ELSE 0 END) AS Não_informado")
        )
            ->where('customers.admin_id', $this->auth_user)
            ->first()
            ->getAttributes();

        foreach ($genders as $gender) {
            $genders_values[] = $gender;
        }

        /* Chart template */
        $genders_graph = [
            'labels' => ['Masculino', 'Feminino', 'Não definido'],
            'datasets' => [
                [
                    'data' => $genders_values,
                    'backgroundColor' => [
                        'rgb(54, 162, 235)',
                        'rgb(255, 99, 132)',
                        'rgb(255, 205, 86)'
                    ]
                ]
            ]
        ];

        /* Query the top five customers with the most vehicles records */
        $customers_count = Customers::select('customers.name', DB::raw('COUNT(vehicles.customer_id) as count'))
            ->leftJoin('vehicles', 'customers.id', '=', 'vehicles.customer_id')
            ->where('customers.admin_id', $this->auth_user)
            ->groupBy('customers.name')
            ->orderBy('count', 'DESC')
            ->limit(5)
            ->get()
            ->pluck('count', 'name')
            ->toArray();


        $label_customers = [];
        $value_customers = [];
        foreach ($customers_count as $name => $count) {
            $label_customers[] = $name;
            $value_customers[] = $count;
        }

        /* Chart template */
        $top_customers_graph = [
            'labels' => $label_customers,
            'datasets' => [
                [
                    'label' => 'Clientes com mais veículos',
                    'data' => $value_customers,
                    'fill' => false,
                    'backgroundColor' => [
                        'rgb(255, 99, 132)',
                        'rgb(54, 162, 235)',
                        'rgb(255, 205, 86)',
                        'rgb(75, 192, 192)',
                        'rgb(153, 102, 255)'
                    ],
                ]
            ]
        ];

        /* Query the last twenty customers in the table */
        $customers_table = Customers::where('admin_id', $this->auth_user)
            ->select('name', 'lastname', 'email', 'phone', 'age', 'gender')
            ->orderBy('id', 'asc')->limit(20)->get();
        $customers_columns = [];

        if ($customers_table->count() > 0) {
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

        /* Query the last twenty vehicles in the table */
        $vehicles_table = Vehicles::select('customers.name', 'vehicles.brand', 'vehicles.model', 'vehicles.year', 'vehicles.color', 'vehicles.steering_system', 'vehicles.type_of_fuel')
            ->leftJoin('customers', 'vehicles.customer_id', '=', 'customers.id')
            ->leftJoin('admins', 'customers.admin_id', '=', "admins.id")
            ->where('customers.admin_id', "$this->auth_user")
            ->orderBy('name', 'asc')->limit(20)->get();
        $vehicles_columns = [];

        /* Table columns. */
        if ($vehicles_table->count() > 0) {
            $vehicles_columns = array_keys($vehicles_table->first()->getAttributes());

            foreach ($vehicles_columns as $key => $column) {
                $translated_column = Lang::get("messages.$column");
                if ($translated_column !== "messages.$column") {
                    /* If the traduce exists, replace the column name with formatted name. */
                    $vehicles_columns[$key] = ucfirst($translated_column);
                } else {
                    /* If the traduce don't exists, capitalize the first letter of the word. */
                    $vehicles_columns[$key] = ucfirst($column);
                }
            }
        }

        /* Query the last twenty reviews in the table */
        $reviews_table = Reviews::select('customers.name', 'vehicles.brand', 'vehicles.model', 'vehicles.year', 'reviews.date_review', 'reviews.problems', 'reviews.completed')
            ->leftJoin('vehicles', 'reviews.vehicle_id', '=', "vehicles.id")
            ->leftJoin('customers', 'vehicles.customer_id', '=', 'customers.id')
            ->leftJoin('admins', 'customers.admin_id', '=', "admins.id")
            ->where('customers.admin_id', "$this->auth_user")
            ->orderBy('name', 'asc')->limit(20)->get();

        $reviews_columns = [];

        /* Table columns. */
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
            'customers_graph' => $customers_graph,
            'vehicles_graph' => $vehicles_graph,
            'reviews_graph' => $reviews_graph,
            'line_graph' => $line_graph,
            'genders_graph' => $genders_graph,
            'top_customers_graph' => $top_customers_graph,
            'customers_table' => $customers_table,
            'customers_columns' => $customers_columns,
            'vehicles_table' => $vehicles_table,
            'vehicles_columns' => $vehicles_columns,
            'reviews_table' => $reviews_table,
            'reviews_columns' => $reviews_columns
        ];

        return view('pdf_file', $data);

    }

    /* Get total records on current date. */
    public function get_total_count_for_date($date)
    {

        $customers_count = Customers::whereDate('created_at', $date)
            ->where('admin_id', $this->auth_user)->count();

        $vehicles_count = Vehicles::whereDate('vehicles.created_at', $date)
            ->leftJoin('customers', 'vehicles.customer_id', '=', 'customers.id')
            ->where('customers.admin_id', $this->auth_user)->count();

        $reviews_count = Reviews::whereDate('reviews.created_at', $date)
            ->leftJoin('vehicles', 'reviews.vehicle_id', '=', 'vehicles.id')
            ->leftJoin('customers', 'vehicles.customer_id', '=', 'customers.id')
            ->where('customers.admin_id', $this->auth_user)->count();

        $total_count = $customers_count + $vehicles_count + $reviews_count;

        return $total_count;
    }
}
