<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    public function register(Request $request, $id = null)
    {
        if (isset(auth()->user()->id)) {
            return redirect()->route('dashboard');
        }
        if($id){
            return view('forgot-password', compact('id'));
        }
        return view('forgot-password');
    }


    public function register_action(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'cpf' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:Users',
            'password' => 'required|string|min:6',
        ]);

        $lider = User::where('codigo', '=', $request->indicacao)->first();

        do {
            $codigo = Str::random(8);
        } while (User::where('codigo', $codigo)->exists());

        if ($lider) {
            $user = User::create([
                'name'              => $request->name,
                'cpf'               => $request->cpf,
                'email'             => $request->email,
                'passwordHash'      => bcrypt($request->password),
                'profile'           => 'user',
                'id_wallet_lider'   => $lider->id_wallet,
                'id_wallet'         => $request->assas,
                'codigo'            => $codigo
            ]);

            Auth::login($user);

            return redirect()->route('dashboard');
        }else{
            return redirect()->route('register')->withErrors(['error' => 'Informe uma indicação!']);
        }

    }
}
