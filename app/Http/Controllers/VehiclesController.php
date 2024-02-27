<?php

namespace App\Http\Controllers;

use App\Models\Customers;
use App\Models\Vehicles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Lang;


class VehiclesController extends Controller
{
    //
    public function index()
    {
        $auth_user = auth()->user()->id;
        $vehicles = Vehicles::select('vehicles.id', 'customers.name', 'vehicles.brand', 'vehicles.model', 'vehicles.year', 'vehicles.color', 'vehicles.steering_system', 'vehicles.type_of_fuel', 'customers.id as customer_id')
            ->leftJoin('customers', 'vehicles.customer_id', '=', 'customers.id')
            ->leftJoin('admins', 'customers.admin_id', '=', "admins.id")
            ->where('customers.admin_id', "$auth_user")
            ->orderBy('name', 'asc')->paginate(5);
        $columns = [];

        if ($vehicles->count() > 0) {
            $columns = array_keys($vehicles->first()->getAttributes());

            foreach ($columns as $key => $column) {
                $translated_column = Lang::get("messages.$column");
                if ($translated_column !== "messages.$column") {
                    // Se a tradução existe, substitue a coluna pelo seu equivalente traduzido
                    $columns[$key] = ucfirst($translated_column);
                } else {
                    // Se a tradução não existe, capitaliza a primeira letra e substitua a coluna
                    $columns[$key] = ucfirst($column);
                }
            }
        }

        return view('vehicles', ['vehicles' => $vehicles, 'columns' => $columns, 'search' => '']);
    }

    public function index_owner($id)
    {
        $auth_user = auth()->user()->id;

        if (!(intval($id) == $id)) {
            return redirect()->route('vehicles');
        }

        $customer = Customers::select('customers.id', 'customers.name', 'customers.lastname', 'customers.email', 'customers.phone')
            ->leftJoin('admins', 'customers.admin_id', '=', "admins.id")
            ->where('customers.id', "$id")
            ->where('admins.id', "$auth_user")
            ->first()
            ->getAttributes();


        if ($customer && $customer['id'] != $id) {
            return view('access_denied');
        }
        $vehicles = Vehicles::select('vehicles.id', 'customers.name', 'vehicles.brand', 'vehicles.model', 'vehicles.year', 'vehicles.color', 'vehicles.steering_system', 'vehicles.type_of_fuel')
            ->leftJoin('customers', 'vehicles.customer_id', '=', 'customers.id')
            ->leftJoin('admins', 'customers.admin_id', '=', "admins.id")
            ->where('customers.admin_id', "$auth_user")
            ->where('vehicles.customer_id', "$id")
            ->orderBy('name', 'asc')->paginate(5);
        $columns = [];

        if ($vehicles->count() > 0) {
            $columns = array_keys($vehicles->first()->getAttributes());

            foreach ($columns as $key => $column) {
                $translated_column = Lang::get("messages.$column");
                if ($translated_column !== "messages.$column") {
                    // Se a tradução existe, substitue a coluna pelo seu equivalente traduzido
                    $columns[$key] = ucfirst($translated_column);
                } else {
                    // Se a tradução não existe, capitaliza a primeira letra e substitua a coluna
                    $columns[$key] = ucfirst($column);
                }
            }
        }

        return view('vehicles_owner', ['vehicles' => $vehicles, 'customer' => $customer, 'columns' => $columns, 'search' => '']);
    }

    public function validator(array $data)
    {
        Alert::error('Erro', 'Um ou mais campos apresentam erro(s). Por favor, corrija os campos destacados.')->persistent(true, true);

        return Validator::make($data, [
            'brand' => ['required', 'string',],
            'model' => ['required', 'string'],
            'year' => ['required', 'integer', 'min:1950', 'max:2024'],
            'color' => ['required', 'string'],
            'steering_system' => ['required', 'string'],
            'type_of_fuel' => ['required', 'string']
        ], [
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
        $this->validator($request->all())->validate();

        Vehicles::create([
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

        if (!(intval($id_customer) == $id_customer)) {
            return redirect()->route('owner', ['id' => $id_customer]);
        }

        $auth_user = auth()->user()->id;

        $customer = Customers::select('customers.id', 'customers.name')
            ->leftJoin('admins', 'customers.admin_id', '=', "admins.id")
            ->where('customers.id', "$id_customer")
            ->where('admins.id', "$auth_user")
            ->first()
            ->getAttributes();

        if ($customer && $customer['id'] != $id_customer) {
            return view('access_denied');
        }

        $vehicle = Vehicles::select('vehicles.id', 'customers.name', 'vehicles.brand', 'vehicles.model', 'vehicles.year', 'vehicles.color', 'vehicles.steering_system', 'vehicles.type_of_fuel')
            ->leftJoin('customers', 'vehicles.customer_id', '=', 'customers.id')
            ->leftJoin('admins', 'customers.admin_id', '=', "admins.id")
            ->where('customers.admin_id', "$auth_user")
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
        $this->validator($request->all())->validate();

        if (!(intval($id_customer) == $id_customer)) {
            return redirect()->route('owner', ['id' => $id_customer]);
        }

        $auth_user = auth()->user()->id;

        $customer = Customers::select('customers.id', 'customers.name')
            ->leftJoin('admins', 'customers.admin_id', '=', "admins.id")
            ->where('customers.id', "$id_customer")
            ->where('admins.id', "$auth_user")
            ->first()
            ->getAttributes();

        if ($customer && $customer['id'] != $id_customer) {
            return view('access_denied');
        }

        $vehicle = Vehicles::where('id', "$id_vehicle")
            ->first();
        
        if ($vehicle) {
            if (
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
            $vehicle->update([
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
        if (!(intval($id_customer) == $id_customer)) {
            return redirect()->route('owner', ['id' => $id_customer]);
        }

        $auth_user = auth()->user()->id;

        $customer = Customers::select('customers.id', 'customers.name')
            ->leftJoin('admins', 'customers.admin_id', '=', "admins.id")
            ->where('customers.id', "$id_customer")
            ->where('admins.id', "$auth_user")
            ->first()
            ->getAttributes();

        if ($customer && $customer['id'] != $id_customer) {
            return view('access_denied');
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
        $query = $request->input('brand');

        $auth_user = auth()->user()->id;
        $vehicles = Vehicles::select('vehicles.id', 'customers.name', 'vehicles.brand', 'vehicles.model', 'vehicles.year', 'vehicles.color', 'vehicles.steering_system', 'vehicles.type_of_fuel', 'customers.id as customer_id')
            ->leftJoin('customers', 'vehicles.customer_id', '=', 'customers.id')
            ->leftJoin('admins', 'customers.admin_id', '=', "admins.id")
            ->where('customers.admin_id', "$auth_user")
            ->where('vehicles.brand', "ilike", '%' . $query . '%')
            ->orderBy('name', 'asc')->paginate(5);
            
        $columns = [];

        if ($vehicles->count() > 0) {
            $columns = array_keys($vehicles->first()->getAttributes());

            foreach ($columns as $key => $column) {
                $translated_column = Lang::get("messages.$column");
                if ($translated_column !== "messages.$column") {
                    // Se a tradução existe, substitue a coluna pelo seu equivalente traduzido
                    $columns[$key] = ucfirst($translated_column);
                } else {
                    // Se a tradução não existe, capitaliza a primeira letra e substitua a coluna
                    $columns[$key] = ucfirst($column);
                }
            }
        }

        return view('vehicles', ['vehicles' => $vehicles, 'columns' => $columns, 'search' => $query]);
    }

    public function search_owner(Request $request, $id)
    {
        $query = $request->input('brand');

        $auth_user = auth()->user()->id;

        if (!(intval($id) == $id)) {
            return redirect()->route('vehicles');
        }

        $customer = Customers::select('customers.id', 'customers.name', 'customers.lastname', 'customers.email', 'customers.phone')
            ->leftJoin('admins', 'customers.admin_id', '=', "admins.id")
            ->where('customers.id', "$id")
            ->where('admins.id', "$auth_user")
            ->first()
            ->getAttributes();


        if ($customer && $customer['id'] != $id) {
            return view('access_denied');
        }
        $vehicles = Vehicles::select('vehicles.id', 'customers.name', 'vehicles.brand', 'vehicles.model', 'vehicles.year', 'vehicles.color', 'vehicles.steering_system', 'vehicles.type_of_fuel')
            ->leftJoin('customers', 'vehicles.customer_id', '=', 'customers.id')
            ->leftJoin('admins', 'customers.admin_id', '=', "admins.id")
            ->where('customers.admin_id', "$auth_user")
            ->where('vehicles.customer_id', "$id")
            ->where('vehicles.brand', "ilike", '%' . $query . '%')
            ->orderBy('name', 'asc')->paginate(5);
        $columns = [];

        if ($vehicles->count() > 0) {
            $columns = array_keys($vehicles->first()->getAttributes());

            foreach ($columns as $key => $column) {
                $translated_column = Lang::get("messages.$column");
                if ($translated_column !== "messages.$column") {
                    // Se a tradução existe, substitue a coluna pelo seu equivalente traduzido
                    $columns[$key] = ucfirst($translated_column);
                } else {
                    // Se a tradução não existe, capitaliza a primeira letra e substitua a coluna
                    $columns[$key] = ucfirst($column);
                }
            }
        }

        return view('vehicles_owner', ['vehicles' => $vehicles, 'customer' => $customer, 'columns' => $columns, 'search' => $query]);
    }
}
