<?php

namespace App\Http\Controllers;

use App\Models\CrmList;
use App\Models\CrmSales;
use App\Models\Notificacao;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CpfcnpjController extends Controller
{
    public function cpfcnpj ()
    {
        $notfic = Notificacao::all();
        $listaAtiva = CrmList::where('status', '=', 1)->firstOrFail();
        return view('dashboard.cpfcnpj',['notfic'=> $notfic],['listaAtiva'=>$listaAtiva]);
        
    }

    public function cadastroCpfCnpj(Request $request)
{
    $request->validate([
        'cpfcnpj'=> 'required|string|max:255',
        'cliente'=> 'required|string|max:255',
        'situacao'=> 'required|string|max:255',
        'dataNascimento'=> 'required|string|max:255',
        'email'=> 'required|string|max:255',
        'telefone'=> 'required|string|max:20',
    ]);
    
    $dataNascimento = Carbon::createFromFormat('d/m/Y', $request->dataNascimento)->format('Y-m-d');
    
    $lista = CrmList::where('status', '=', 1)->firstOrFail();

    $user = CrmSales::create([
        'cpfcnpj' => $request->cpfcnpj,
        'cliente' => $request->cliente,
        'situacao' => $request->situacao,
        'dataNascimento' => $dataNascimento,
        'email' => $request->email,
        'telefone' => $request->telefone,
        'id_lista'=> $lista->id,
        'id_user' => Auth()->user()->id,
        'status'=>'PENDING',
    ]);
    
    return redirect()->route('cpfcnpj');
}


    
}
