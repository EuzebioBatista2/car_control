<?php

namespace App\Http\Controllers;

use App\Models\Customers;
use App\Models\Reviews;
use App\Models\Vehicles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Lang;


class VehiclesController extends Controller
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

        /* Query the last five vehicles(paginate) in the table */
        $vehicles = Vehicles::select('vehicles.id', 'customers.name', 'vehicles.plate', 'vehicles.brand', 'vehicles.model', 'vehicles.year', 'vehicles.color', 'vehicles.steering_system', 'customers.id as customer_id')
            ->leftJoin('customers', 'vehicles.customer_id', '=', 'customers.id')
            ->leftJoin('admins', 'customers.admin_id', '=', "admins.id")
            ->where('customers.admin_id', "$this->auth_user")
            ->orderBy('vehicles.id', 'asc')->paginate(5);

        $columns = [];

        $vehicles_columns = Vehicles::select('vehicles.id', 'customers.name', 'vehicles.plate', 'vehicles.brand', 'vehicles.model', 'vehicles.year', 'vehicles.color', 'vehicles.steering_system')
            ->leftJoin('customers', 'vehicles.customer_id', '=', 'customers.id')
            ->leftJoin('admins', 'customers.admin_id', '=', "admins.id")
            ->first()
            ->getAttributes();

        /* Columns table */
        $columns_query = array_keys($vehicles_columns);

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

        return view('vehicles', ['vehicles' => $vehicles, 'columns' => $columns, 'select' => '', 'data' => '']);
    }

    public function index_owner($id)
    {
        $this->auth_user = auth()->user()->id;

        /* Is the ID integer? */
        if (!(intval($id) == $id)) {
            return redirect()->route('vehicles');
        }

        /* Query the first customer with ID(Query) and User ID */
        $customer = Customers::select('customers.id', 'customers.name', 'customers.lastname', 'customers.email', 'customers.phone')
            ->leftJoin('admins', 'customers.admin_id', '=', "admins.id")
            ->where('customers.id', "$id")
            ->where('admins.id', "$this->auth_user")
            ->first()
            ->getAttributes();

        /* If the customer ID is different from the id  */
        if ($customer && $customer['id'] != $id) {
            return view('access_denied');
        }

        /* Query the last five vehicles(paginate) in the table */
        $vehicles = Vehicles::select('vehicles.id', 'vehicles.plate', 'vehicles.brand', 'vehicles.model', 'vehicles.year', 'vehicles.color', 'vehicles.steering_system', 'vehicles.type_of_fuel')
            ->leftJoin('customers', 'vehicles.customer_id', '=', 'customers.id')
            ->leftJoin('admins', 'customers.admin_id', '=', "admins.id")
            ->where('customers.admin_id', "$this->auth_user")
            ->where('vehicles.customer_id', "$id")
            ->orderBy('vehicles.id', 'asc')->paginate(5);

        $columns = [];

        /* Columns table */
        $vehicles_columns = Vehicles::select('vehicles.id', 'vehicles.plate', 'vehicles.brand', 'vehicles.model', 'vehicles.year', 'vehicles.color', 'vehicles.steering_system', 'vehicles.type_of_fuel')
            ->leftJoin('customers', 'vehicles.customer_id', '=', 'customers.id')
            ->leftJoin('admins', 'customers.admin_id', '=', "admins.id")
            ->first()
            ->getAttributes();

        /* Columns table */
        $columns_query = array_keys($vehicles_columns);

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

        return view('vehicles_owner', ['vehicles' => $vehicles, 'customer' => $customer, 'columns' => $columns, 'select' => '', 'data' => '']);
    }

    public function validator(array $data)
    {
        Alert::error('Erro', 'Um ou mais campos apresentam erro(s). Por favor, corrija os campos destacados.')->persistent(true, true);

        return Validator::make($data, [
            'plate' => ['required', 'string', 'max:8', 'min:8', 'regex:/^[A-Za-z]{3}-[0-9]{1}[A-Za-z0-9]{1}[0-9]{2}$/'],
            'brand' => ['required', 'string',],
            'model' => ['required', 'string'],
            'year' => ['required', 'integer', 'min:1950', 'max:2024'],
            'color' => ['required', 'string'],
            'steering_system' => ['required', 'string'],
            'type_of_fuel' => ['required', 'string']
        ], [
            /* Plate */
            'plate.required' => 'O campo placa deve ser preenchido.',
            'plate.string' => 'Placa deve ser do tipo TEXTO',
            'plate.max' => 'Placa acima do limite permitido, max:8.',
            'plate.min' => 'Placa abaixo do limite permitido, min:8.',
            'plate.regex' => 'Fomato inválido, a placa deve possuir o seguinte formato: ABC-1A23 ou ABC-1234.',

            /* Brand */
            'brand.required' => 'O campo marca deve ser preenchido.',
            'brand.string' => 'Marca deve ser do tipo TEXTO',

            /* Model */
            'model.required' => 'O campo modelo deve ser preenchido.',
            'model.string' => 'Modelo deve ser do tipo TEXTO',

            /* Year */
            'year.required' => 'O campo ano deve ser preenchido.',
            'year.integer' => 'Ano deve ser do tipo INTEIRO',
            'year.max' => 'Ano acima do limite permitido, max:2024.',
            'year.min' => 'Ano abaixo do limite permitido, min:1950.',

            /* Color */
            'color.required' => 'O campo cor deve ser preenchido.',
            'color.string' => 'Cor deve ser do tipo TEXTO',

            /* Steering_system */
            'steering_system.required' => 'O campo sistema de direção deve ser preenchido.',
            'steering_system.string' => 'Sistema de direção deve ser do tipo TEXTO',

            /* Type_of_fuel */
            'type_of_fuel.required' => 'O campo tipo de combutível deve ser preenchido.',
            'type_of_fuel.string' => 'Tipo de combutível deve ser do tipo NÚMERICO',

        ]);
    }

    public function create(Request $request, int $id)
    {
        /* Verify if the data is valid. */
        $this->validator($request->all())->validate();

        /* Format plate */
        $formated_plate = strtoupper($request->input('plate'));

        Vehicles::create([
            'plate' => $formated_plate,
            'brand' => $request->input('brand'),
            'model' => $request->input('model'),
            'year' => $request->input('year'),
            'color' => $request->input('color'),
            'steering_system' => $request->input('steering_system'),
            'type_of_fuel' => $request->input('type_of_fuel'),
            'customer_id' => $id
        ]);

        Alert::success('Sucesso', 'Cadastro de veículo realizado com sucesso.')->persistent(true, true);

        return redirect()->route('owner', ['id' => $id]);
    }

    public function edit($id_customer, $id_vehicle)
    {

        $this->auth_user = auth()->user()->id;

        /* Verify if the id_customer is integer. */
        if (!(intval($id_customer) == $id_customer)) {
            return redirect()->route('owner', ['id' => $id_customer]);
        }

        /* Query the first customer by id_customer */
        $customer = Customers::select('customers.id', 'customers.name')
            ->leftJoin('admins', 'customers.admin_id', '=', "admins.id")
            ->where('customers.id', "$id_customer")
            ->where('admins.id', "$this->auth_user")
            ->first()
            ->getAttributes();

        /* If the customer ID is different from the id_customer  */
        if ($customer && $customer['id'] != $id_customer) {
            return view('access_denied');
        }

        /* Query the first vehicle with the user ID, vehicle ID and the id_customer. */
        $vehicle = Vehicles::select('vehicles.id', 'vehicles.plate', 'vehicles.brand', 'vehicles.model', 'vehicles.year', 'vehicles.color', 'vehicles.steering_system', 'vehicles.type_of_fuel')
            ->leftJoin('customers', 'vehicles.customer_id', '=', 'customers.id')
            ->leftJoin('admins', 'customers.admin_id', '=', "admins.id")
            ->where('customers.admin_id', "$this->auth_user")
            ->where('vehicles.customer_id', "$id_customer")
            ->where('vehicles.id', "$id_vehicle")
            ->first();

        if ($vehicle) {
            $vehicle_data = $vehicle->toArray();
            return view('edit_vehicle', ['vehicle' => $vehicle_data, 'customer' => $customer]);
        }

        return view('access_denied');
    }

    public function update(Request $request, $id_customer, $id_vehicle)
    {
        $this->auth_user = auth()->user()->id;

        /* Verify if the data is valid. */
        $this->validator($request->all())->validate();

        /* Is the ID integer? */
        if (!(intval($id_customer) == $id_customer)) {
            return redirect()->route('owner', ['id' => $id_customer]);
        }

        /* Query the first customer with the user ID and the id_customer. */
        $customer = Customers::select('customers.id', 'customers.name')
            ->leftJoin('admins', 'customers.admin_id', '=', "admins.id")
            ->where('customers.id', "$id_customer")
            ->where('admins.id', "$this->auth_user")
            ->first()
            ->getAttributes();

        /* If the customer ID is different from the id_customer */
        if ($customer && $customer['id'] != $id_customer) {
            return view('access_denied');
        }

        $vehicle = Vehicles::where('id', "$id_vehicle")
            ->first();

        if ($vehicle) {
            /* Verify if the vehicle query is different from the requested data. */
            if (
                $vehicle['plate'] === $request->input('plate') &&
                $vehicle['brand'] === $request->input('brand') &&
                $vehicle['model'] === $request->input('model') &&
                $vehicle['year'] == $request->input('year') &&
                $vehicle['color'] === $request->input('color') &&
                $vehicle['steering_system'] == $request->input('steering_system') &&
                $vehicle['type_of_fuel'] === $request->input('type_of_fuel')
            ) {
                Alert::warning('Aviso', 'Prencha os campos com novos dados para realizar uma atualização!')->persistent(true, true);
                return redirect()->route('owner', ['id' => $id_customer]);
            }

            /* Format plate */
            $formated_plate = strtoupper($request->input('plate'));

            $vehicle->update([
                'plate' => $formated_plate,
                'brand' => $request->input('brand'),
                'model' => $request->input('model'),
                'year' => $request->input('year'),
                'color' => $request->input('color'),
                'steering_system' => $request->input('steering_system'),
                'type_of_fuel' => $request->input('type_of_fuel')
            ]);
        } else {
            return view('access_denied');
        }

        Alert::success('Sucesso', 'Cadastro de cliente atualizado com sucesso!')->persistent(true, true);

        return redirect()->route('owner', ['id' => $id_customer]);
    }

    public function destroy($id_customer, $id_vehicle)
    {

        $this->auth_user = auth()->user()->id;

        /* Is the ID integer? */
        if (!(intval($id_customer) == $id_customer)) {
            return redirect()->route('owner', ['id' => $id_customer]);
        }

        /* Query the first customer with the user ID and the customer ID. */
        $customer = Customers::select('customers.id', 'customers.name')
            ->leftJoin('admins', 'customers.admin_id', '=', "admins.id")
            ->where('customers.id', "$id_customer")
            ->where('admins.id', "$this->auth_user")
            ->first()
            ->getAttributes();

        /* If the customer ID is different from the id_customer  */
        if ($customer && $customer['id'] != $id_customer) {
            return view('access_denied');
        }

        /* Query the number of reviews before deleting */
        $reviews = Reviews::select('id')
            ->leftJoin('vehicles', 'reviews.vehicle_id', '=', 'vehicles.id')
            ->leftJoin('customers', 'vehicles.customer_id', '=', 'customers.id')
            ->where('reviews.vehicle_id', $id_vehicle)
            ->where('customers.admin_id', $this->auth_user)->count();

        if ($reviews > 0) {
            Alert::error('Erro', 'Cadastro de veículo possui um ou mais revisão(ões) cadastrada(s)!')->persistent(true, true);
            return redirect()->route('owner', ['id' => $id_customer]);
        }

        $vehicle = Vehicles::where('id', $id_vehicle)->first();

        if ($vehicle) {
            Alert::success('Sucesso', 'Cadastro de cliente excluído com sucesso!')->persistent(true, true);
            $vehicle->delete();
        } else {
            Alert::error('Erro', 'Infelizmente não foi possivel excluir o registro selecionado.')->persistent(true, true);
        }

        return redirect()->route('owner', ['id' => $id_customer]);
    }

    public function search(Request $request)
    {

        $select = $request->input('select');
        $data = $request->input('data');

        $this->auth_user = auth()->user()->id;

        $vehicles_columns = Vehicles::select('vehicles.id', 'vehicles.plate', 'customers.name', 'vehicles.brand', 'vehicles.model', 'vehicles.year', 'vehicles.color', 'vehicles.steering_system')
            ->leftJoin('customers', 'vehicles.customer_id', '=', 'customers.id')
            ->leftJoin('admins', 'customers.admin_id', '=', "admins.id")
            ->first()
            ->getAttributes();

        /* Select don't macha the customers_columns */
        if (!in_array($select, array_keys($vehicles_columns))) {
            return view('access_denied');
        }

        $query_select = $select === "name" ? "customers." . $select : "vehicles." . $select;

        /* Query the last five vehicles(paginate) with User ID and query */
        $vehicles = Vehicles::select('vehicles.id', 'vehicles.plate',  'customers.name', 'vehicles.brand', 'vehicles.model', 'vehicles.year', 'vehicles.color', 'vehicles.steering_system', 'customers.id as customer_id')
            ->leftJoin('customers', 'vehicles.customer_id', '=', 'customers.id')
            ->leftJoin('admins', 'customers.admin_id', '=', "admins.id")
            ->where('customers.admin_id', "$this->auth_user")
            ->where("$query_select", "ilike", '%' . $data . '%')
            ->orderBy('vehicles.id', 'asc')->paginate(5);

        $columns = [];

        /* Table columns */
        $columns_query = array_keys($vehicles_columns);

        foreach ($columns_query as $column) {
            $translated_column = Lang::get("messages.$column");
            if ($translated_column !== "messages.$column") {
                // Se a tradução existe, substitue a coluna pelo seu equivalente traduzido
                $columns[$column] = ucfirst($translated_column);
            } else {
                // Se a tradução não existe, capitaliza a primeira letra e substitua a coluna
                $columns[$column] = ucfirst($column);
            }
        }

        return view('vehicles', ['vehicles' => $vehicles, 'columns' => $columns, 'data' => $data, 'select' => $select]);
    }

    public function search_owner(Request $request, $id)
    {

        $select = $request->input('select');
        $data = $request->input('data');

        $this->auth_user = auth()->user()->id;

        /* Is the ID integer? */
        if (!(intval($id) == $id)) {
            return redirect()->route('vehicles');
        }

        $vehicles_columns = Vehicles::select('vehicles.id', 'vehicles.plate', 'vehicles.brand', 'vehicles.model', 'vehicles.year', 'vehicles.color', 'vehicles.steering_system', 'vehicles.type_of_fuel')
            ->leftJoin('customers', 'vehicles.customer_id', '=', 'customers.id')
            ->leftJoin('admins', 'customers.admin_id', '=', "admins.id")
            ->first()
            ->getAttributes();

        /* Select don't macha the customers_columns */
        if (!in_array($select, array_keys($vehicles_columns))) {
            return view('access_denied');
        }

        /* Query the first customer with the ID and the User ID */
        $customer = Customers::select('customers.id', 'customers.name', 'customers.lastname', 'customers.email', 'customers.phone')
            ->leftJoin('admins', 'customers.admin_id', '=', "admins.id")
            ->where('customers.id', "$id")
            ->where('admins.id', "$this->auth_user")
            ->first()
            ->getAttributes();

        /* If the customer ID is different from the id */
        if ($customer && $customer['id'] != $id) {
            return view('access_denied');
        }

        $query_select = $select === "name" ? "customers." . $select : "vehicles." . $select;

        /* Query the last five vehicles(paginate) with User ID and query */
        $vehicles = Vehicles::select('vehicles.id', 'vehicles.plate', 'vehicles.brand', 'vehicles.model', 'vehicles.year', 'vehicles.color', 'vehicles.steering_system', 'vehicles.type_of_fuel')
            ->leftJoin('customers', 'vehicles.customer_id', '=', 'customers.id')
            ->leftJoin('admins', 'customers.admin_id', '=', "admins.id")
            ->where('customers.admin_id', "$this->auth_user")
            ->where('vehicles.customer_id', "$id")
            ->where("$query_select", "ilike", '%' . $data . '%')
            ->orderBy('vehicles.id', 'asc')->paginate(5);

        $columns = [];

        /* Table columns */
        $columns_query = array_keys($vehicles_columns);

        foreach ($columns_query as $column) {
            $translated_column = Lang::get("messages.$column");
            if ($translated_column !== "messages.$column") {
                // Se a tradução existe, substitue a coluna pelo seu equivalente traduzido
                $columns[$column] = ucfirst($translated_column);
            } else {
                // Se a tradução não existe, capitaliza a primeira letra e substitua a coluna
                $columns[$column] = ucfirst($column);
            }
        }

        return view('vehicles_owner', ['vehicles' => $vehicles, 'customer' => $customer, 'columns' => $columns, 'data' => $data, 'select' => $select]);
    }
}
