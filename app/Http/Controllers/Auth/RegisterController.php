<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

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
    protected $redirectTo = '/';

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
            'name' => 'required|max:255|unique:users',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:7|max:30|regex:/^(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{7,30}$.*$/|confirmed',
            'password_confirmation' => 'required|min:7|max:30'
        ], [
            'name.required' => 'Le nom d\'usager est nécessaire.',
            'email.required' => 'L\'adresse email est nécessaire.',
            'password.required' => 'Le mot de passe est nécessaire.',
            'password_confirmation.required' => 'Le mot de passe de confirmation est nécessaire.',
            'name.max' => 'Le nom d\'usager peut contenir un maximum de 255 caractères.',
            'email.max' => 'L\'adresse email peut contenir un maximum de 255 caractères.',
            'password.max' => 'Le mot de passe peut contenir un maximum de 255 caractères.',
            'password_confirmation.max' => 'Le mot de passe de confirmation peut contenir un maximum de 255 caractères.',
            'name.unique' => 'Le nom d\'usager est déjà pris.',
            'email.unique' => 'L\'adresse courriel est déjà prise.',
            'password.min' => 'Le mot de passe doit contenir au minimum 7 caractères.',
            'password_confirmation.min' => 'Le mot de passe doit contenir au minimum 7 caractères.',
            'password.regex' => 'Le mot de passe doit contenir une majuscule, 7 caractères au minimum et 30 caractères au maximum.',
            'password.confirmed' => 'Le mot de passe de confirmation doit être identique au mot de passe.'
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        var_dump($data);
        return User::create([
            'name' => $data['name'],
            'phone_number' => $data['phone_number'],
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }
}
