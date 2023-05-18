<?php

namespace App\Http\Controllers;

use App\Models\Notificacao;
use App\Models\User;
use Dotenv\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class PerfilController extends Controller
{
    public function perfil ()
    {
        $dados = Auth::User();
        $users = auth()->user();

        $notfic = Notificacao::where(function ($query) use ($users) {
            if ($users->profile === 'admin') {
                $query->where(function ($query) {
                    $query->where('tipo', '!=', '') // Todas as notificações
                        ->orWhere('tipo', 0); // Notificações com tipo igual a 0
                });
            } else {
                $query->where(function ($query) use ($users) {
                    $query->where('tipo', 0) // Notificações com tipo igual a 0
                        ->orWhere('tipo', $users->id); // Notificações com tipo igual ao ID do usuário logado
                });
            }
        })->get();

        return view('dashboard.perfil',['notfic'=> $notfic],['dados'=> $dados]);

    }
    public function perfilimg(Request $request)
    {
        $request->validate([
            'perfil' => 'image|max:2048',// 2 MB
        ]);

        if (!Auth::check()) {
            return redirect()->route('login'); // ou para outra página de login
        }

        $user = Auth::user();

        if ($request->hasFile('perfil')) {
            $path = $request->file('perfil')->store('public/profiles');
            $url = Storage::url($path);

            // salva o caminho da imagem no banco de dados
            $user->perfil = $url;
            $user->save();
        } else {
            // usa a imagem perfil.png se não tiver uma foto enviada pelo usuário
            if (!$user->perfil) {
                $user->perfil = 'public/profiles/perfil.png';
                $user->save();
            }
        }

        // redireciona para a página de perfil
        return redirect()->route('perfil');
    }





    public function update(Request $request)
    {
        $user = Auth::user(); // obtem o usuario autenticado

        if ($request->filled('name')) { // verifica se o novo nome foi fornecido
            $user->name = $request->input('name'); // atualiza o nome do usuario
        }

        if ($request->filled('email')) { // verifica se o novo email foi fornecido
            $user->email = $request->input('email'); // atualiza o email do usuario
        }

        if ($request->filled('passwordHash')) { // verifica se a nova senha foi fornecida
            $user->passwordHash = Hash::make($request->input('passwordHash')); // atualiza a senha do usuario
        }

        $user->save(); // salva as alterações

        return redirect()->back()->with('success', 'Perfil atualizado com sucesso.'); // redireciona para a pagina anterior com uma mensagem de sucesso
    }



}
