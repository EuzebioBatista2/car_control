<?php

namespace App\Http\Controllers;

use App\Models\Admins;
use App\Models\Customers;
use App\Models\Reviews;
use App\Models\Vehicles;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    public function index()
    {
        return view('account');
    }

    public function validator_informations(array $data)
    {
        $user_id = auth()->user()->id;

        Alert::error('Erro', 'Um ou mais campos apresentam erro(s). Por favor, corrija os campos destacados.')->persistent(true, true);

        if(isset($data['email']))
        {
            $data['email'] = strtolower($data['email']);
            $data['email'] = ucfirst($data['email']);
        }

        return Validator::make($data, [
            'name' => ['required', 'string', 'min:3', 'max:45', 'regex:/^[A-Za-zãáàéèêíìóòôõúùûüç ]+$/'],
            'lastname' => ['required', 'string', 'min:3', 'max:45', 'regex:/^[A-Za-zãáàéèêíìóòôõúùûüç ]+$/'],
            'email' => ['required', 'string', 'min:8', 'max:100', 'email', Rule::unique('admins')->ignore($user_id)],
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

        ]);
    }

    public function validator_password(array $data)
    {
        Alert::error('Erro', 'Um ou mais campos apresentam erro(s). Por favor, corrija os campos destacados.')->persistent(true, true);

        $user_id = auth()->user()->id;
        $admin = Admins::find($user_id);

        return Validator::make($data, [
            'current_password' => ['required', function ($attribute, $value, $fail) use ($admin) {
                if (!Hash::check($value, $admin->password)) {
                    $fail(__('Senha atual invalída.'));
                }
            }],
            'password' => ['required', 'string', 'min:8', 'max:20', 'confirmed', 'regex:/^(?=.*[!@#$])(?=.*[0-9].*[0-9].*[0-9])(?=.*[a-z])(?=.*[A-Z])/'],
        ], [

            /* Current password */
            'current_password.required' => 'O campo senha atual deve ser preenchido.',

            /* Password */
            'password.required' => 'O campo nova senha deve ser preenchido',
            'password.confirmed' => 'Senhas não conferem',
            'password.min' => 'É necessário no mínimo 8 caracteres',
            'password.max' => 'Nova senha acima do limite permitido, max:20.',
            'password.regex' => 'A nova senha deve conter: pelo menos 1 caractere especial [!@$#], no mínimo 3 números, 1 caractere minúsculo e 1 caractere maiúsculo.',

        ]);
    }

    public function update_informations(Request $request)
    {
        $user_id = auth()->user()->id;

        /* Format the name, lastname and email input. */
        $capitalize_name = strtolower($request->input('name'));
        $capitalize_lastname = strtolower($request->input('lastname'));
        $capitalize_email = strtolower($request->input('email'));

        /* Query the admin by id */
        $admin = Admins::where('id', $user_id)->first();

        if (
            $admin['name'] === ucfirst($capitalize_name) &&
            $admin['lastname'] === ucwords($capitalize_lastname) &&
            $admin['email'] === ucfirst($capitalize_email)
        ) {
            Alert::warning('Aviso', 'Prencha os campos com novos dados para realizar uma atualização!')->persistent(true, true);
            return redirect()->route('account');
        }

        $this->validator_informations($request->all())->validate();

        $admin->update([
            'name' => ucfirst($capitalize_name),
            'lastname' => ucwords($capitalize_lastname),
            'email' => ucfirst($capitalize_email)
        ]);

        Alert::success('Sucesso', 'Dados de administrador atualizado com sucesso!')->persistent(true, true);

        return redirect()->route('account');
    }

    public function updade_password(Request $request)
    {
        $this->validator_password($request->all())->validate();

        $user_id = auth()->user()->id;

        /* Query the admin by id */
        $admin = Admins::where('id', $user_id)->first();

        /* Check if the password isn't new */
        if (Hash::check($request->input('password'), $admin->password)) {
            Alert::warning('Aviso', 'Senha já utilizada, por favor, digite uma nova senha!')->persistent(true, true);
            return redirect()->route('account');
        }

        $admin->update([
            'password' => Hash::make($request->input('password'))
        ]);

        Alert::success('Sucesso', 'Senha de administrador atualizado com sucesso!')->persistent(true, true);

        return redirect()->route('account');
    }

    public function destroy()
    {
        $user_id = auth()->user()->id;

        /* Reviews total */
        Reviews::where('customers.admin_id', "$user_id")
            ->leftJoin('vehicles', 'reviews.vehicle_id', '=', "vehicles.id")
            ->leftJoin('customers', 'vehicles.customer_id', '=', 'customers.id')
            ->leftJoin('admins', 'customers.admin_id', '=', "admins.id")
            ->delete();


        /* Total vehicles */
        Vehicles::where('customers.admin_id', "$user_id")
            ->leftJoin('customers', 'vehicles.customer_id', '=', 'customers.id')
            ->leftJoin('admins', 'customers.admin_id', '=', "admins.id")
            ->delete();

        /* Total customers */
        Customers::where('admin_id', $user_id)->delete();

        $admin = Admins::where('id', $user_id)->first();
        $admin->delete();

        Alert::success('Sucesso', 'Conta excluída com sucesso!')->persistent(true, true);
        Auth::logout();
        return redirect()->route('login');
    }
}
