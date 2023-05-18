<?php

namespace App\Http\Controllers;

use App\Models\CrmList;
use App\Models\CrmSales;
use App\Models\Notificacao;
use App\Models\User;
use Illuminate\Http\Request;
use App\Exports\SalesExport;
use Maatwebsite\Excel\ExcelServiceProvider;
use Maatwebsite\Excel\Facades\Excel;
use SebastianBergmann\Exporter\Exporter;

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

        $userlist = User::orderBy('name')->get();

        return view('dashboard.lista', [
            'lists' => $lists,
            'notfic' => $notfic,
            'userlist' => $userlist,
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

    // public function export($id_lista)
    // {
    // // Obter o status da lista correspondente
    // $list = CrmList::find($id_lista);
    // $status = $list->confirmed_status;

    // // Verificar o status da lista e definir a consulta adequada
    // if ($status == 1) {
    //     $sales = CrmSales::where('id_lista', $id_lista)->get();
    // } else {
    //     $user_id = auth()->user()->id;
    //     $sales = CrmSales::where('id_lista', $id_lista)
    //                       ->where('id_user', $user_id)
    //                       ->get();
    // }

    // // Exportar os dados para o Excel
    // return Excel::download(new Exporter($sales), 'sales.xlsx');
    // }




  
}
