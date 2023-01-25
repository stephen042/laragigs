<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    //show Register Page/ Create Form
    public function create(){
        return view('users.register');
    }

    // Create New User
    public function store(Request $request)
    {
        $formfield = $request->validate([
            'name' => ['required', 'min:3'],
            'email' => ['required', 'email', Rule::unique('users','email')],
            'password' => ['required','confirmed', Password::min(6)->mixedCase()]
        ]);

        // Hash Password
        $formfield['password'] = bcrypt($formfield['password']);

        // Create user
        User::create($formfield);

        // redirect
        return redirect('/login')->with('message', 'You have registered successfully');

    }

    // log out
    public function logout(Request $request){
        auth()->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('message', 'you have logout successfully');
    }

    // Show Login Form
    public function login(){
        return view('users.login');
    }

    // auth user
    public function authenticate(Request $request){

        $formfield = $request->validate([
            'email' => ['required', 'email'],
            'password' => 'required'
        ]);

        if (auth()->attempt($formfield)) {
           $request->session()->regenerate();

           return redirect('/')->with('message', 'You are now logged in ');
        }
        
        return back()->withErrors(['email' => 'invalid Credentials'])->onlyInput('email');
    }
}
