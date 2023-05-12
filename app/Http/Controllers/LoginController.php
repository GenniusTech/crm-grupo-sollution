<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index(Request $request)
    {   
        
        if (isset(auth()->user()->id)) {
            return redirect()->route('dashboard');
        }
        return view('index');
       
    }

    public function login_action(Request $request)
    {
        $credentials = $request->only(['email', 'passwordHash']);
        $credentials['password'] = $credentials['passwordHash'];
        if (Auth::attempt($credentials)) {
            // Autenticação bem-sucedida
            return redirect()->intended('dashboard');
        } else {
            // Autenticação falha
            return redirect()->back()->withErrors(['email' => 'As credenciais fornecidas são inválidas.']);
        }
    }
    
}
