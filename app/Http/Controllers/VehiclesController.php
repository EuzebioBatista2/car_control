<?php

namespace App\Http\Controllers;

use App\Models\Customers;
use App\Models\Vehicles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Lang;
use Illuminate\Validation\Rule;

class VehiclesController extends Controller
{
    //
    public function index()
    {
        $vehicles = Vehicles::select('vehicles.id', 'customers.name', 'vehicles.brand', 'vehicles.model', 'vehicles.year', 'vehicles.color', 'vehicles.steering_system', 'vehicles.type_of_fuel')
            ->leftJoin('customers', 'vehicles.customer_id', '=', 'customers.id')
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

    public function validator(array $data, $id = null)
    {
        Alert::error('Erro', 'Um ou mais campos apresentam erro(s). Por favor, corrija os campos destacados.')->persistent(true, true);

        return Validator::make($data, [
            'name' => ['required', 'string', 'min:3', 'max:45', 'regex:/^[A-Za-zãáàéèêíìóòôõúùûüç]+$/'],
            'lastname' => ['required', 'string', 'min:3', 'max:45', 'regex:/^[A-Za-zãáàéèêíìóòôõúùûüç ]+$/'],
            'email' => ['required', 'string', 'min:8', 'max:100', 'email', Rule::unique('customers')->ignore($id)],
            'phone' => ['required', 'string', 'max:15', 'regex:/^\(\d{2}\)\s\d{4,5}-\d{4}$/'],
            'age' => ['required', 'integer', 'min:18', 'max:100', 'digits_between:1,4'],
            'gender' => ['required', 'string', 'max:1', 'regex:/^(M|F|N)$/']
        ], [
            /* Name */
            'name.required' => 'O campo nome deve ser preenchido.',
            'name.string' => 'Nome deve ser do tipo TEXTO',
            'name.min' => 'Nome abaixo do limite permitido, min:3.',
            'name.max' => 'Nome acima do limite permitido, max:45.',
            'name.regex' => 'O campo nome não deve conter números',

            /* Lastname */
            'lastname.required' => 'O campo sobrenome deve ser preenchido.',
            'lastname.string' => 'Sobrenome deve ser do tipo TEXTO',
            'lastname.min' => 'Sobrenome abaixo do limite permitido, min:3.',
            'lastname.max' => 'Sobrenome acima do limite permitido, max:45.',
            'lastname.regex' => 'O campo sobrenome não deve conter números',

            /* Email */
            'email.required' => 'O campo e-mail deve ser preenchido.',
            'email.string' => 'E-mail deve ser do tipo TEXTO',
            'email.max' => 'E-mail acima do limite permitido, max:100.',
            'email.min' => 'E-mail abaixo do limite permitido, min:8.',
            'email.email' => 'O campo deve ser do tipo email: email@email.com',
            'email.unique' => 'E-mail já cadastrado.',

            /* Phone */
            'phone.required' => 'O campo contato deve ser preenchido.',
            'phone.string' => 'Contato deve ser do tipo TEXTO',
            'phone.max' => 'Contato acima do limite permitido, max:15.',
            'phone.regex' => 'Formato inválido: Ex:(99) 99999-9999 ou 9999-9999',

            /* Age */
            'age.required' => 'O campo idade deve ser preenchido.',
            'age.integer' => 'Idade deve ser do tipo NÚMERICO',
            'age.min' => 'Idade acima do limite permitido, min:18.',
            'age.max' => 'Idade abaixo do limite permitido, max:100.',
            'age.digits_between' => 'A Idade deve ser um número entre 1 e 3 dígitos',

            /* Gender */
            'gender.required' => 'O campo sexo deve ser preenchido.',
            'gender.string' => 'Sexo deve ser do tipo TEXTO',
            'gender.max' => 'Sexo acima do limite permitido, max:1.',
            'gender.regex' => 'Opção do sexo inválida: Ex: M, F ou N',

        ]);
    }

    public function create(Request $request)
    {
        $this->validator($request->all())->validate();

        $capitalize_name = strtolower($request->input('name'));
        $capitalize_lastname = strtolower($request->input('lastname'));
        $capitalize_email = strtolower($request->input('email'));

        Customers::create([
            'name' => ucfirst($capitalize_name),
            'lastname' => ucwords($capitalize_lastname),
            'email' => ucfirst($capitalize_email),
            'phone' => $request->input('phone'),
            'age' => $request->input('age'),
            'gender' => $request->input('gender'),
            'admin_id' => auth()->user()->id
        ]);

        Alert::success('Sucesso', 'Cadastro de cliente realizado com sucesso.')->persistent(true, true);

        return redirect()->route('customers');
    }

    public function edit($id)
    {

        if (!(intval($id) == $id)) {
            return redirect()->route('customers');
        }


        $admin_id = auth()->user()->id;
        $customer = Customers::where('id', $id)
            ->where('admin_id', $admin_id)
            ->first();

        if ($customer) {
            $customer_data = $customer->toArray();
            return view('edit_customer', ['customer' => $customer_data]);
        }

        return view('access_denied');
    }

    public function update(Request $request, int $id)
    {
        $this->validator($request->all(), $id)->validate();

        $capitalize_name = strtolower($request->input('name'));
        $capitalize_lastname = strtolower($request->input('lastname'));
        $capitalize_email = strtolower($request->input('email'));

        $customer = Customers::where('id', $id)->first();
        if ($customer) {
            if (
                $customer['name'] === ucfirst($capitalize_name) &&
                $customer['lastname'] === ucwords($capitalize_lastname) &&
                $customer['email'] === ucfirst($capitalize_email) &&
                $customer['phone'] === $request->input('phone') &&
                $customer['age'] == $request->input('age') &&
                $customer['gender'] === $request->input('gender')
            ) {
                Alert::warning('Aviso', 'Prencha os campos com novos dados para realizar uma atualização!')->persistent(true, true);
                return redirect()->route('customers');
            }
            $customer->update([
                'name' => ucfirst($capitalize_name),
                'lastname' => ucwords($capitalize_lastname),
                'email' => ucfirst($capitalize_email),
                'phone' => $request->input('phone'),
                'age' => $request->input('age'),
                'gender' => $request->input('gender')
            ]);
        }

        Alert::success('Sucesso', 'Cadastro de cliente atualizado com sucesso!')->persistent(true, true);

        return redirect()->route('customers');
    }

    public function destroy(int $id)
    {
        $customer = Customers::where('id', $id)->first();
        if ($customer) {
            Alert::success('Sucesso', 'Cadastro de cliente excluído com sucesso!')->persistent(true, true);
            $customer->delete();
        } else {
            Alert::error('Erro', 'Infelizmente não foi possivel excluir o registro selecionado.')->persistent(true, true);
        }

        return redirect()->route('customers');
    }

    public function search(Request $request)
    {
        $query = $request->input('name');

        $admin_id = auth()->user()->id;
        $customers = Customers::where('admin_id', $admin_id)
            ->where("name", "ilike", '%' . $query . '%')
            ->select('id', 'name', 'lastname', 'email', 'phone', 'age', 'gender')
            ->orderBy('id', 'asc')->paginate(5);
        $columns = [];

        if ($customers->count() > 0) {
            $columns = array_keys($customers->first()->getAttributes());

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

        return view('customers', ['customers' => $customers, 'columns' => $columns, 'search' => $query]);
    }
}
