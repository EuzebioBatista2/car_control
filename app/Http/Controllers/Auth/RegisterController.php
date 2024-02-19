<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Admins;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

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
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:45'],
            'lastname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:admins'],
            'password' => ['required', 'string', 'min:8', 'confirmed', 'regex:/^(?=.*[!@#$])(?=.*[0-9].*[0-9].*[0-9])/'],
        ], [
            'name.required' => 'O campo nome deve ser preenchido',
            'name.max' => 'Nome acima do limite permitido, max:45.',
            'lastname.required' => 'O campo sobrenome deve ser preenchido',
            'lastname.max' => 'Sobrenome acima do limite permitido, max:255.',
            'email.required' => 'O campo e-mail deve ser preenchido',
            'email.unique' => 'O email já existe',
            'email.email' => 'O e-mail inserido não possui um formato valido',
            'password.required' => 'O campo senha deve ser preenchido',
            'password.confirmed' => 'Senhas não conferem',
            'password.min' => 'É necessário no mínimo 8 caracteres',
            'password.regex' => 'A senha deve conter: 1 caractere especial e no mínimo 3 números.'
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
        return Admins::create([
            'name' => $data['name'],
            'lastname' => $data['lastname'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }
}
