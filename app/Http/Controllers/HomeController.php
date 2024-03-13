<?php

namespace App\Http\Controllers;

use App\Models\Customers;
use App\Models\Reviews;
use App\Models\Vehicles;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /* User ID at login */
    private $auth_user;
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function __construct()
    {
        $this->middleware('auth');
        $this->auth_user = '';
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    /* Initial page */
    public function index()
    {

        $this->auth_user = auth()->user()->id;

        /* Query the number of the customers. */
        $customers = Customers::select('id')->where('admin_id', $this->auth_user)->count();

        /* Query the number of the vehicles. */
        $vehicles = Vehicles::select('id')
            ->leftJoin('customers', 'vehicles.customer_id', '=', 'customers.id')
            ->where('customers.admin_id', $this->auth_user)->count();

        /* Query the number of the reviews. */
        $reviews = Reviews::select('id')
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
        $gender_data = [
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
        $top_customers = [
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

        return view('home', ['customers' => $customers, 'vehicles' => $vehicles, 'reviews' => $reviews, 'line_graph' => $line_graph, 'genders' => $gender_data, 'top_customers' => $top_customers]);
    }

    /* Get total records on current date. */
    public function get_total_count_for_date($date)
    {

        $customers_count = Customers::select('id')->whereDate('customers.created_at', $date)
            ->where('admin_id', $this->auth_user)->orderBy('id')->count();

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
