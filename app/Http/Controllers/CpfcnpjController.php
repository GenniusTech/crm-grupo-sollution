<?php

namespace App\Http\Controllers;

use App\Models\CrmList;
use App\Models\CrmSales;
use App\Models\Notificacao;
use Carbon\Carbon;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session as FacadesSession;
use Illuminate\Support\Facades\Storage;

class CpfcnpjController extends Controller
{
    public function cpfcnpj()
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
        
        $listaAtiva = CrmList::where('status', '=', 1)->first();
        
        if (!$listaAtiva) {
            return redirect()->route('list')->with('mensagem', 'A lista ativa não foi encontrada. Por favor, cadastre ou ative uma lista.');
        }
        
        
        return view('dashboard.cpfcnpj', ['notfic' => $notfic, 'listaAtiva' => $listaAtiva]);
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
            'file' => 'file|max:2048', // 2 MB
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
            'status' => 'PENDING',
        ]);
    
        if ($request->hasFile('file')) {
            $path = $request->file('file')->store('public/profiles');
            $url = Storage::url($path);
    
            // Salva o caminho da imagem no banco de dados
            $user->file = $url;
            $user->save();
        }
    
        if (!$user) {
            return redirect()->route('cpfcnpj')->withErrors(['Falha no cadastro. Por favor, tente novamente.']);
        }
    
        // Cadastro bem-sucedido, define a mensagem de sucesso na sessão
        FacadesSession::flash('success', 'Cadastro realizado com sucesso.');
    
        return redirect()->route('cpfcnpj');
    }

    
    
    


    
}
