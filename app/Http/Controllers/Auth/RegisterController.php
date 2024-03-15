<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Admins;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        Alert::error('Erro', 'Um ou mais campos apresentam erro(s). Por favor, corrija os campos destacados.')->persistent(true, true);
        
        $data['email'] = strtolower($data['email']);
        $data['email'] = ucfirst($data['email']);

        return Validator::make($data, [
            'name' => ['required', 'string', 'min:3', 'max:45', 'regex:/^[A-Za-zãáàéèêíìóòôõúùûüç]+$/'],
            'lastname' => ['required', 'string', 'min:3', 'max:45', 'regex:/^[A-Za-zãáàéèêíìóòôõúùûüç ]+$/'],
            'email' => ['required', 'string', 'unique:admins,email', 'min:8', 'max:100', 'email'],
            'password' => ['required', 'string', 'min:8', 'max:20', 'confirmed', 'regex:/^(?=.*[!@#$])(?=.*[0-9].*[0-9].*[0-9])(?=.*[a-z])(?=.*[A-Z])/'],
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
            'email.min' => 'E-mail abaixo do limite permitido, min:8.',
            'email.max' => 'E-mail acima do limite permitido, max:100.',
            'email.email' => 'O campo deve ser do tipo email: email@email.com',
            'email.unique' => 'E-mail já cadastrado.',
            
            /* Password */
            'password.required' => 'O campo senha deve ser preenchido',
            'password.confirmed' => 'Senhas não conferem',
            'password.min' => 'É necessário no mínimo 8 caracteres',
            'password.max' => 'Senha acima do limite permitido, max:20.',
            'password.regex' => 'A senha deve conter: pelo menos 1 caractere especial [!@$#], no mínimo 3 números, 1 caractere minúsculo e 1 caractere maiúsculo.'
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\Admins
     */
    protected function create(array $data)
    {
        Alert::success('Sucesso', 'Cadastro de administrador realizado com sucesso.')->persistent(true, true);

        /* Format the name, lastname and email input */
        $capitalize_name = strtolower($data['name']);
        $capitalize_lastname = strtolower($data['lastname']);
        $capitalize_email = strtolower($data['email']);

        return Admins::create([
            'name' => ucfirst($capitalize_name),
            'lastname' => ucwords($capitalize_lastname),
            'email' => ucfirst($capitalize_email),
            'password' => Hash::make($data['password']),
        ]);
    }
}
