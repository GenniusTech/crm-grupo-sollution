<?php

namespace App\Http\Controllers;

use App\Models\CrmList;
use App\Models\CrmSales;
use App\Models\Notificacao;
use App\Models\Ticket;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DashController extends Controller
{
    public function dashboard (){
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



        $user = Auth::user();
        $query = CrmSales::where('status_limpanome', 'CONFIRMED');

        if ($user->profile !== 'admin') {
            $query->where('id_user', $user->id);
        }

        $total = $query->count();

        $today = Carbon::today();
        $user = Auth::user();
        $userId = $user->id;
        $isAdmin = $user->profile === 'admin';
        $tickets = Ticket::whereDate('createdAt', $today);
        if (!$isAdmin) {
            $tickets->where('userId', $userId);
        }
        $count = $tickets->count();
        $percent = ($count * 10 <= 100) ? $count * 10 : 100;

        $sales = CrmSales::where('id_user', $user->id)
        ->whereHas('list', function ($query) {
            $query->where('status', 1)
                ->where('produto', 2);
        })
        ->get();


        $users = User::orderBy('name')->get();

        $listname = CrmList::where('status', 1)->pluck('titulo');


        return view('dashboard.index', [
            'notfic' => $notfic,
            'total' => $total,
            'count' => $count,
            'percent' => $percent,
            'sales' => $sales,
            'users' => $users,
            'listname' => $listname
        ]);


    }

    public function downloadArquivo($id)
    {
        // Obtenha o registro do CRM_Sales pelo ID
        $crmSales = CrmSales::find($id);

        if ($crmSales->status_consulta === 'DISPONIVEL') {
            // Obtenha o caminho do arquivo do banco de dados
            $caminhoArquivo = $crmSales->file_consulta;

            // Extraia o nome do arquivo do caminho
            $nomeArquivo = basename($caminhoArquivo);
            // dd($nomeArquivo);
            if (Storage::exists('public/profiles/' . $nomeArquivo)) {
                return Storage::download('public/profiles/' . $nomeArquivo);
            } else {
                return response()->json(['error' => 'Arquivo não encontrado.'], 404);
            }
        } else {
            return response()->json(['error' => 'O status da consulta não é DISPONIVEL.'], 400);
        }
    }




    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
