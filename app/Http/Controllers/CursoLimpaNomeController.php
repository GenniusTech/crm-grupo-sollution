<?php

namespace App\Http\Controllers;

use App\Models\Notificacao;
use Illuminate\Http\Request;

class CursoLimpaNomeController extends Controller
{
    public function cursoLimpaNome ()
    {
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
        
        return view('dashboard.cursoLimpaNome',['notfic'=> $notfic]);
        
    }
}

