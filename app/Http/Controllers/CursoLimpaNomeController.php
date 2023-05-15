<?php

namespace App\Http\Controllers;

use App\Models\Notificacao;
use Illuminate\Http\Request;

class CursoLimpaNomeController extends Controller
{
    public function cursoLimpaNome ()
    {
        $user = auth()->user(); // Supondo que você esteja usando autenticação

        $notfic = Notificacao::where(function ($query) use ($user) {
            if ($user->profile === 'admin') {
                $query->where('tipo', '!=', ''); // Todas as notificações
            } else {
                $query->where('tipo', 0) // Notificações com tipo igual a 0
                    ->orWhere('tipo', $user->id); // Notificações com tipo igual ao ID do usuário logado
            }
        })->get();
        
        return view('dashboard.cursoLimpaNome',['notfic'=> $notfic]);
        
    }
}

