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
        $users = auth()->user();

        $notfic = Notificacao::where(function ($query) use ($users) {
            if ($users->profile === 'admin') {
                $query->where(function ($query) {
                    $query->where('tipo', '!=', '')
                        ->orWhere('tipo', 0);
                });
            } else {
                $query->where(function ($query) use ($users) {
                    $query->where('tipo', 0)
                        ->orWhere('tipo', $users->id);
                });
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
            'endereco'=> 'string',
            'file' => 'file|max:2048', // 2 MB
        ]);

        $dataNascimento = Carbon::createFromFormat('d/m/Y', $request->dataNascimento)->format('Y-m-d');

        $lista = CrmList::where('status', '=', 1)->firstOrFail();

        $user = CrmSales::create([
            'cpfcnpj'           => $request->cpfcnpj,
            'cliente'           => $request->cliente,
            'situacao'          => $request->situacao,
            'dataNascimento'    => $dataNascimento,
            'email'             => $request->email,
            'telefone'          => $request->telefone,
            'id_lista'          => $lista->id,
            'endereco'          => $request->cep.' - '.$request->endereco.', '.$request->num,
            'id_user'           => Auth()->user()->id,
            'id_wallet'         => Auth()->user()->id_wallet,
            'id_wallet_lider'   => Auth()->user()->id_wallet_lider,
            'status'            => 'PENDING',
        ]);

        if ($request->hasFile('file')) {
            $path = $request->file('file')->store('public/profiles');
            $url = Storage::url($path);

            $user->file = $url;
            $user->save();
        }

        if (!$user) {
            return redirect()->route('cpfcnpj')->withErrors(['Falha no cadastro. Por favor, tente novamente.']);
        }

        FacadesSession::flash('success', 'Cadastro realizado com sucesso.');

        return redirect()->route('dashboard');
    }


}
