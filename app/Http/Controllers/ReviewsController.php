<?php

namespace App\Http\Controllers;

use App\Models\Customers;
use App\Models\Reviews;
use App\Models\Vehicles;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Lang;


class ReviewsController extends Controller
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

        /* Query the last five reviews(paginete) with user ID. */
        $reviews = Reviews::select('reviews.id', 'customers.name', 'vehicles.brand', 'vehicles.model', 'vehicles.year', 'vehicles.plate', 'reviews.date_review', 'reviews.problems', 'reviews.completed', 'vehicles.id as vehicle_id')
            ->leftJoin('vehicles', 'reviews.vehicle_id', '=', "vehicles.id")
            ->leftJoin('customers', 'vehicles.customer_id', '=', 'customers.id')
            ->leftJoin('admins', 'customers.admin_id', '=', "admins.id")
            ->where('customers.admin_id', "$this->auth_user")
            ->orderBy('name', 'asc')->paginate(10);

        $columns = [];

        $reviews_columns = Reviews::select('reviews.id', 'customers.name', 'vehicles.brand', 'vehicles.model', 'vehicles.year', 'vehicles.plate', 'reviews.date_review', 'reviews.problems')
            ->leftJoin('vehicles', 'reviews.vehicle_id', '=', "vehicles.id")
            ->leftJoin('customers', 'vehicles.customer_id', '=', 'customers.id')
            ->leftJoin('admins', 'customers.admin_id', '=', "admins.id")
            ->first()
            ->getAttributes();

        /* Columns table */
        $columns_query = array_keys($reviews_columns);

        foreach ($columns_query as $column) {
            $translated_column = Lang::get("messages.$column");
            if ($translated_column !== "messages.$column") {
                /* If the traduce exists, replace the column name with formatted name. */
                $columns[$column] = ucfirst($translated_column);
            } else {
                /* If the traduce don't exists, capitalize the first letter of the word. */
                $columns[$column] = ucfirst($column);
            }
        }

        return view('reviews', ['reviews' => $reviews, 'columns' => $columns, 'select' => '', 'data' => '']);
    }

    /* Inital page with ID */
    public function index_owner_review($id)
    {

        $this->auth_user = auth()->user()->id;

        /* Is the ID integer? */
        if (!(intval($id) == $id)) {
            return redirect()->route('reviews');
        }

        /* Query the first vehicle with the user ID and the vehicle ID. */
        $vehicle = Vehicles::select('vehicles.id', 'customers.name', 'customers.lastname', 'customers.email', 'customers.phone', 'vehicles.brand', 'vehicles.model', 'vehicles.year', 'vehicles.plate')
            ->leftJoin('customers', 'vehicles.customer_id', '=', "customers.id")
            ->leftJoin('admins', 'customers.admin_id', '=', "admins.id")
            ->where('vehicles.id', "$id")
            ->where('admins.id', "$this->auth_user")
            ->first();

        if ($vehicle) {
            $vehicle->getAttributes();
        }

        /* If the Vehicle ID isn't from the user  */
        if ($vehicle === null) {
            return view('access_denied');
        }

        /* Query the last five reviews(paginete) with the user ID and the vehicle ID. */
        $reviews = Reviews::select('reviews.id', 'reviews.date_review', 'reviews.problems', 'reviews.completed')
            ->leftJoin('vehicles', 'reviews.vehicle_id', '=', "vehicles.id")
            ->leftJoin('customers', 'vehicles.customer_id', '=', 'customers.id')
            ->leftJoin('admins', 'customers.admin_id', '=', "admins.id")
            ->where('customers.admin_id', "$this->auth_user")
            ->where('reviews.vehicle_id', "$id")
            ->orderBy('date_review', 'asc')->paginate(10);

        /* Table columns. */
        $columns = [];

        $reviews_columns = Reviews::select('reviews.id', 'reviews.date_review', 'reviews.problems', 'reviews.completed')
            ->leftJoin('vehicles', 'reviews.vehicle_id', '=', "vehicles.id")
            ->leftJoin('customers', 'vehicles.customer_id', '=', 'customers.id')
            ->leftJoin('admins', 'customers.admin_id', '=', "admins.id")
            ->first()
            ->getAttributes();

        $columns_query = array_keys($reviews_columns);

        foreach ($columns_query as $key => $column) {
            $translated_column = Lang::get("messages.$column");
            if ($translated_column !== "messages.$column") {
                /* If the traduce exists, replace the column name with formatted name. */
                $columns[$key] = ucfirst($translated_column);
            } else {
                /* If the traduce don't exists, capitalize the first letter of the word. */
                $columns[$key] = ucfirst($column);
            }
        }

        /* Format date */
        $current_date = date('Y-m-d\TH:i');

        return view('reviews_owner', ['reviews' => $reviews, 'vehicle' => $vehicle, 'columns' => $columns, 'old_date' => '', 'date' => $current_date]);
    }

    public function validator(array $data)
    {
        Alert::error('Erro', 'Um ou mais campos apresentam erro(s). Por favor, corrija os campos destacados.')->persistent(true, true);

        return Validator::make($data, [
            'problems' => ['required', 'string', 'min:3', 'max:255'],
        ], [
            /* Problems */
            'problems.required' => 'O campo problema(s) encontrado(s) deve ser preenchido.',
            'problems.string' => 'Problema(s) deve ser do tipo TEXTO',
            'peoblemas.min' => 'Problema(s) abaixo do limite permitido, min:3.',
            'peoblemas.max' => 'Problema(s) acima do limite permitido, max:255.',
        ]);
    }

    public function create(Request $request, int $id)
    {
        /* Verify if the data is valid. */
        $this->validator($request->all())->validate();

        Reviews::create([
            'vehicle_id' => $request->input('vehicle_id'),
            'problems' => $request->input('problems'),
            'date_review' => date('Y-m-d H:i:s'),
            'completed' => '0',
        ]);

        Alert::success('Sucesso', 'Cadastro de revisão realizado com sucesso.')->persistent(true, true);

        return redirect()->route('owner_review', ['id' => $id]);
    }

    public function edit($id_vehicle, $id_review)
    {

        $this->auth_user = auth()->user()->id;

        /* Verify if the id_vehicle is integer. */
        if (!(intval($id_vehicle) == $id_vehicle)) {
            return redirect()->route('reviews');
        }

        /* Verify if the id_vehicle is integer. */
        if (!(intval($id_review) == $id_review)) {
            return redirect()->route('owner_review', ['id' => $id_vehicle]);
        }

        /* Query the first vehicle by id_vehicle */
        $vehicle = Vehicles::select('vehicles.id', 'customers.name', 'customers.lastname', 'customers.email', 'customers.phone', 'vehicles.brand', 'vehicles.model', 'vehicles.year', 'vehicles.color')
            ->leftJoin('customers', 'vehicles.customer_id', '=', "customers.id")
            ->leftJoin('admins', 'customers.admin_id', '=', "admins.id")
            ->where('vehicles.id', "$id_vehicle")
            ->where('admins.id', "$this->auth_user")
            ->first();

        if ($vehicle) {
            $vehicle->getAttributes();
        }

        /* If the Vehicle ID isn't from the user  */
        if ($vehicle === null) {
            return view('access_denied');
        }

        /* Query the first review with the user ID and the vehicle ID. */
        $review = Reviews::select('reviews.id', 'reviews.date_review', 'reviews.problems', 'reviews.completed', 'vehicles.id as vehicle_id')
            ->leftJoin('vehicles', 'reviews.vehicle_id', '=', "vehicles.id")
            ->leftJoin('customers', 'vehicles.customer_id', '=', 'customers.id')
            ->leftJoin('admins', 'customers.admin_id', '=', "admins.id")
            ->where('customers.admin_id', "$this->auth_user")
            ->where('reviews.vehicle_id', "$id_vehicle")
            ->where('reviews.id', "$id_review")
            ->first();

        if ($review) {
            $review->getAttributes();
        }

        /* If the review ID isn't from the user  */
        if ($review === null) {
            return view('access_denied');
        }

        /* Format date */
        $review['date_review'] = substr($review['date_review'], 0, 10) . 'T' . substr($review['date_review'], 11, 5);

        return view('edit_review', ['review' => $review]);
    }

    public function update(Request $request, $id_vehicle, $id_review)
    {
        $this->auth_user = auth()->user()->id;

        /* Verify if the data is valid. */
        $this->validator($request->all())->validate();

        /* Is the ID integer? */
        if (!(intval($id_vehicle) == $id_vehicle)) {
            return redirect()->route('owner_review', ['id' => $id_vehicle]);
        }

        /* Query the first vehicle with the user ID and the vehicle ID. */
        $vehicle = Vehicles::select('vehicles.id', 'customers.name', 'customers.lastname', 'customers.email', 'customers.phone', 'vehicles.brand', 'vehicles.model', 'vehicles.year', 'vehicles.color')
            ->leftJoin('customers', 'vehicles.customer_id', '=', "customers.id")
            ->leftJoin('admins', 'customers.admin_id', '=', "admins.id")
            ->where('vehicles.id', "$id_vehicle")
            ->where('admins.id', "$this->auth_user")
            ->first();

        if ($vehicle) {
            $vehicle->getAttributes();
        }

        /* If the vehicle ID is different from the user  */
        if ($vehicle === null) {
            return view('access_denied');
        }

        /* Query the first reviews with the user ID and the vehicle ID. */
        $review = Reviews::select('reviews.id', 'reviews.date_review', 'reviews.problems', 'reviews.completed', 'vehicles.id as vehicle_id')
            ->leftJoin('vehicles', 'reviews.vehicle_id', '=', "vehicles.id")
            ->leftJoin('customers', 'vehicles.customer_id', '=', 'customers.id')
            ->leftJoin('admins', 'customers.admin_id', '=', "admins.id")
            ->where('customers.admin_id', "$this->auth_user")
            ->where('reviews.vehicle_id', "$id_vehicle")
            ->where('reviews.id', "$id_review")
            ->first();

        /* Format date */
        $review['date_review'] = substr($review['date_review'], 0, 10) . 'T' . substr($review['date_review'], 11, 5);

        /* Format completed input */
        $format_completed = $request->input('completed') ? '1' : '0';

        if ($review) {
            /* Verify if the reviewed query is different from the requested data. */
            if (
                $review['date_review'] === $request->input('date_review') &&
                $review['completed'] === $format_completed &&
                $review['problems'] == $request->input('problems')
            ) {
                Alert::warning('Aviso', 'Preencha os campos com novos dados para realizar uma atualização!')->persistent(true, true);
                return redirect()->route('owner_review', ['id' => $id_vehicle]);
            }

            $review->update([
                'date_review' => $request->input('date_review'),
                'completed' => $format_completed,
                'problems' => $request->input('problems'),
            ]);
        } else {
            return view('access_denied');
        }

        Alert::success('Sucesso', 'Cadastro de revisão atualizado com sucesso!')->persistent(true, true);

        return redirect()->route('owner_review', ['id' => $id_vehicle]);
    }

    public function completed_task(Request $request, $id)
    {
        /* Is the ID integer? */
        if (!(intval($id) == $id)) {
            return view('access_denied');
        }

        $value = $request->input('value');

        /* Query the first reviews with the user ID and the vehicle ID. */
        $review = Reviews::where('id', $id)
            ->first();

        $review->update([
            'completed' => $value,
        ]);

        /* return redirect()->route('owner_review', ['id' => $vehicle_id]); */
    }

    public function destroy($id_vehicle, $id_review)
    {

        $this->auth_user = auth()->user()->id;

        /* Is the vehicle ID integer? */
        if (!(intval($id_vehicle) == $id_vehicle)) {
            return redirect()->route('reviews');
        }

        /* Is the review ID integer? */
        if (!(intval($id_review) == $id_review)) {
            return redirect()->route('owner_review', ['id' => $id_vehicle]);
        }

        /* Query the first review with the user ID and the vehicle ID. */
        $vehicle = Vehicles::select('vehicles.id', 'customers.name', 'customers.lastname', 'customers.email', 'customers.phone', 'vehicles.brand', 'vehicles.model', 'vehicles.year', 'vehicles.color')
            ->leftJoin('customers', 'vehicles.customer_id', '=', "customers.id")
            ->leftJoin('admins', 'customers.admin_id', '=', "admins.id")
            ->where('vehicles.id', "$id_vehicle")
            ->where('admins.id', "$this->auth_user")
            ->first();

        if ($vehicle) {
            $vehicle->getAttributes();
        }

        /* If the vehicle ID isn't from the user  */
        if ($vehicle === null) {
            return view('access_denied');
        }

        /* Query the first review with the user ID and the vehicle ID. */
        $review = Reviews::select('reviews.id', 'reviews.date_review', 'reviews.problems', 'reviews.completed', 'vehicles.id as vehicle_id')
            ->leftJoin('vehicles', 'reviews.vehicle_id', '=', "vehicles.id")
            ->leftJoin('customers', 'vehicles.customer_id', '=', 'customers.id')
            ->leftJoin('admins', 'customers.admin_id', '=', "admins.id")
            ->where('customers.admin_id', "$this->auth_user")
            ->where('reviews.vehicle_id', "$id_vehicle")
            ->where('reviews.id', "$id_review")
            ->first();

        if ($review) {
            $review->getAttributes();
        }

        /* If the review ID isn't from the user  */
        if ($review === null) {
            return view('access_denied');
        }

        /* Query the first review by ID */
        $review = Reviews::where('id', $id_review)->first();

        if ($review) {
            Alert::success('Sucesso', 'Cadastro de revisão excluído com sucesso!')->persistent(true, true);
            $review->delete();
        }

        return redirect()->route('owner_review', ['id' => $id_vehicle]);
    }

    public function search(Request $request)
    {

        $select = $request->input('select');
        $data = $request->input('data');

        $this->auth_user = auth()->user()->id;

        $reviews_columns = Reviews::select('reviews.id', 'customers.name', 'vehicles.brand', 'vehicles.model', 'vehicles.year', 'vehicles.color', 'reviews.date_review', 'reviews.problems')
            ->leftJoin('vehicles', 'reviews.vehicle_id', '=', "vehicles.id")
            ->leftJoin('customers', 'vehicles.customer_id', '=', 'customers.id')
            ->leftJoin('admins', 'customers.admin_id', '=', "admins.id")
            ->first()
            ->getAttributes();

        /* Select don't match the customers_columns */
        if (!in_array($select, array_keys($reviews_columns))) {
            return view('access_denied');
        }

        if ($select === "name") {
            $query_select = "customers." . $select;
        } else if ($select === "brand" || $select === "model" || $select === "year" || $select === "color") {
            $query_select = "vehicles." . $select;
        } else {
            $query_select = "reviews." . $select;
        }

        /* Query the last five reviews(paginate) with User ID and query */
        $reviews = Reviews::select('reviews.id', 'customers.name', 'vehicles.brand', 'vehicles.model', 'vehicles.year', 'vehicles.color', 'reviews.date_review', 'reviews.problems', 'reviews.completed', 'vehicles.id as vehicle_id')
            ->leftJoin('vehicles', 'reviews.vehicle_id', '=', "vehicles.id")
            ->leftJoin('customers', 'vehicles.customer_id', '=', 'customers.id')
            ->leftJoin('admins', 'customers.admin_id', '=', "admins.id")
            ->where('customers.admin_id', "$this->auth_user")
            ->where("$query_select", "ilike", '%' . $data . '%')
            ->orderBy('name', 'asc')->paginate(10);

        $columns = [];

        /* Table columns */
        $columns_query = array_keys($reviews_columns);

        foreach ($columns_query as $column) {
            $translated_column = Lang::get("messages.$column");
            if ($translated_column !== "messages.$column") {
                /* If the traduce exists, replace the column name with formatted name. */
                $columns[$column] = ucfirst($translated_column);
            } else {
                /* If the traduce don't exists, capitalize the first letter of the word. */
                $columns[$column] = ucfirst($column);
            }
        }

        return view('reviews', ['reviews' => $reviews, 'columns' => $columns, 'data' => $data, 'select' => $select]);
    }

    public function search_owner(Request $request, $id)
    {
        $this->auth_user = auth()->user()->id;

        $initial_date = $request->input('initial_date');
        $final_date = $request->input('final_date');

        /* Is the ID integer? */
        if (!(intval($id) == $id)) {
            return redirect()->route('reviews');
        }

        /* Query the first vehicle with the ID and the User ID */
        $vehicle = Vehicles::select('vehicles.id', 'customers.name', 'customers.lastname', 'customers.email', 'customers.phone', 'vehicles.brand', 'vehicles.model', 'vehicles.year', 'vehicles.plate')
            ->leftJoin('customers', 'vehicles.customer_id', '=', "customers.id")
            ->leftJoin('admins', 'customers.admin_id', '=', "admins.id")
            ->where('vehicles.id', "$id")
            ->where('admins.id', "$this->auth_user")
            ->first();

        if ($vehicle) {
            $vehicle->getAttributes();
        }

        /* If the vehicle ID is different from the id  */
        if ($vehicle === null) {
            return view('access_denied');
        }

        $formated_initial = DateTime::createFromFormat('Y-m-d\TH:i', $initial_date);
        $formated_final = DateTime::createFromFormat('Y-m-d\TH:i', $final_date);

        if ($formated_initial  === false && $initial_date !== null or $formated_final === false) {
            return view('access_denied');
        }

        /* Query the last five reviews(paginate) with User ID and query */
        $reviews = Reviews::select('reviews.id', 'reviews.date_review', 'reviews.problems', 'reviews.completed')
            ->leftJoin('vehicles', 'reviews.vehicle_id', '=', 'vehicles.id')
            ->leftJoin('customers', 'vehicles.customer_id', '=', 'customers.id')
            ->leftJoin('admins', 'customers.admin_id', '=', 'admins.id')
            ->where('customers.admin_id', $this->auth_user)
            ->where('reviews.vehicle_id', $id);

        if ($initial_date != '') {
            $reviews->whereBetween('reviews.date_review', [$initial_date, $final_date]);
        } else {
            $reviews->where('reviews.date_review', '<=', $final_date);
        }

        $reviews = $reviews->orderBy('date_review', 'desc')
            ->paginate(10);

        $columns = [];

        $reviews_columns = Reviews::select('reviews.id', 'reviews.date_review', 'reviews.problems', 'reviews.completed')
            ->leftJoin('vehicles', 'reviews.vehicle_id', '=', "vehicles.id")
            ->leftJoin('customers', 'vehicles.customer_id', '=', 'customers.id')
            ->leftJoin('admins', 'customers.admin_id', '=', "admins.id")
            ->first()
            ->getAttributes();

        $columns_query = array_keys($reviews_columns);

        foreach ($columns_query as $key => $column) {
            $translated_column = Lang::get("messages.$column");
            if ($translated_column !== "messages.$column") {
                /* If the traduce exists, replace the column name with formatted name. */
                $columns[$key] = ucfirst($translated_column);
            } else {
                /* If the traduce don't exists, capitalize the first letter of the word. */
                $columns[$key] = ucfirst($column);
            }
        }

        /* Format date */
        $current_date = date('Y-m-d\TH:i');

        return view('reviews_owner', ['reviews' => $reviews, 'vehicle' => $vehicle, 'columns' => $columns, 'old_date' => $initial_date, 'date' => $current_date]);
    }
}
