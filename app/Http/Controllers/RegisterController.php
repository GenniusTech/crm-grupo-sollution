<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserQueue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function register(Request $request)
    {
        if (isset(auth()->user()->id)) {
            return redirect()->route('dashboard');
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

        $user = User::create([
            'name' => $request->name,
            'cpf' => $request->cpf,
            'email' => $request->email,
            'passwordHash' => bcrypt($request->password),
            'profile' => 'user',
        ]);

        $createdAt = '2023-05-23 15:31:47';

        UserQueue::create([
            'userId' => $user->id,
            'queueId' => 1,
            'createdAt' => $createdAt,
            'updatedAt' => $createdAt,
        ]);

        Auth::login($user);

        return redirect()->route('dashboard');
    }
}
