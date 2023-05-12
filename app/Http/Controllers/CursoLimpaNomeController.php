<?php

namespace App\Http\Controllers;

use App\Models\Notificacao;
use Illuminate\Http\Request;

class CursoLimpaNomeController extends Controller
{
    public function cursoLimpaNome ()
    {
        $notfic = Notificacao::all();
        return view('dashboard.cursoLimpaNome',['notfic'=> $notfic]);
        
    }
}

