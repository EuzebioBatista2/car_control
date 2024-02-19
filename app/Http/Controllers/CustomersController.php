<?php

namespace App\Http\Controllers;

use App\Models\Customers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Lang;

class CustomersController extends Controller
{
    //
    public function index()
    {
        $admin_id = auth()->user()->id;
        $customers = Customers::where('admin_id', $admin_id)
        ->select('id', 'name', 'lastname', 'email', 'phone', 'age', 'gender')
        ->orderBy('id', 'asc')->paginate(10);
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

        return view('customers', ['customers' => $customers, 'columns' => $columns]);
    }

    public function validator(array $data)
    {
        Alert::error('Erro', 'Um ou mais campos apresentam erro(s). Por favor, corrija os campos destacados.')->persistent(true, true);
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:45', 'regex:/^[A-Za-z]+$/'],
            'lastname' => ['required', 'string', 'max:45', 'regex:/^[A-Za-z]+$/'],
            'email' => ['required', 'string', 'max:255', 'email', 'unique:customers'],
            'phone' => ['required', 'string', 'max:15', 'regex:/^\(\d{2}\)\s\d{4,5}-\d{4}$/'],
            'age' => ['required', 'integer', 'max:150', 'digits_between:1,4'],
            'gender' => ['required', 'string', 'max:1', 'regex:/^(M|F|N)$/']
        ], [
            /* Name */
            'name.required' => 'O campo nome deve ser preenchido.',
            'name.string' => 'Nome deve ser do tipo TEXTO',
            'name.max' => 'Nome acima do limite permitido, max:45.',
            'name.regex' => 'O campo nome não deve conter números',

            /* Lastname */
            'lastname.required' => 'O campo sobrenome deve ser preenchido.',
            'lastname.string' => 'Sobrenome deve ser do tipo TEXTO',
            'lastname.max' => 'Sobrenome acima do limite permitido, max:45.',
            'lastname.regex' => 'O campo sobrenome não deve conter números',

            /* Email */
            'email.required' => 'O campo e-mail deve ser preenchido.',
            'email.string' => 'E-mail deve ser do tipo TEXTO',
            'email.max' => 'E-mail acima do limite permitido, max:255.',
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
            'age.max' => 'Idade acima do limite permitido, max:150.',
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


        Customers::create([
            'name' => $request->input('name'),
            'lastname' => $request->input('lastname'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'age' => $request->input('age'),
            'gender' => $request->input('gender'),
            'admin_id' => auth()->user()->id
        ]);

        Alert::success('Sucesso', 'Cadastro de cliente realizado com sucesso.')->persistent(true, true);

        return redirect()->route('customers');
    }
}
