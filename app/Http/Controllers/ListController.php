<?php

namespace App\Http\Controllers;

use App\Models\CrmList;
use App\Models\CrmSales;
use App\Models\Notificacao;
use App\Models\User;
use Illuminate\Http\Request;
use App\Exports\SalesExport;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\ExcelServiceProvider;
use Maatwebsite\Excel\Facades\Excel;
use SebastianBergmann\Exporter\Exporter;
use Illuminate\Support\Facades\Session as FacadesSession;


class ListController extends Controller
{

    public function list()
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

        $lists = CrmList::all();

        $sales = CrmSales::where('status_consulta', 'PAYMENT_RECEIVED')
        ->orWhere('status_consulta', 'PAYMENT_CONFIRMED')
        ->get();


        $userlist = User::orderBy('name')->get();

        return view('dashboard.lista', [
            'lists' => $lists,
            'notfic' => $notfic,
            'userlist' => $userlist,
            'sales' =>$sales,
        ]);
    }



    public function cadastroList(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'dataInicial' => 'required|max:255',
            'dataFinal' => 'required',
        ]);

        $user = CrmList::create([
            'titulo' => $request->titulo,
            'dataInicial' => $request->dataInicial,
            'dataFinal' => $request->dataFinal,
            'status' => 0,
        ]);


        return redirect()->route('list');
    }

    public function ativarLista($id)
    {

        $lists = CrmList::all();

        // Atualiza o status de todas as listas do usuário para 0, exceto a lista ativada
        foreach ($lists as $list) {
            if ($list->id == $id) {
                $list->status = 1;
            } else {
                $list->status = 0;
            }
            $list->save();
        }

        return redirect()->back();
    }

     public function GerarConsultas(Request $request, $id)
    {

        $request->validate([
            'file' => 'file|max:2048', // 2 MB
        ]);

        $user = CrmSales::find($id);

        if (!$user) {
            return redirect()->route('list')->withErrors(['Registro não encontrado.']);
        }

        if ($request->hasFile('file')) {
            $path = $request->file('file')->store('public/profiles');
            $url = Storage::url($path);

            // Atualiza o campo 'file_consulta' com o novo documento
            $user->file_consulta = $url;
            $user->status_consulta = 'DISPONIVEL';
            $user->save();

        }

        $users = User::where('id',$user->id_user);
        // Incrementa o campo 'consulta_m' em 1
        $users->increment('consulta_m');



        // Cadastro bem-sucedido, define a mensagem de sucesso na sessão
        FacadesSession::flash('success', 'Cadastro realizado com sucesso.');


        return redirect()->route('list');

    }
}
