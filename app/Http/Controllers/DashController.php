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

class DashController extends Controller
{
    public function dashboard (){
        $user = auth()->user(); // Supondo que você esteja usando autenticação

        $notfic = Notificacao::where(function ($query) use ($user) {
            if ($user->profile === 'admin') {
                $query->where('tipo', '!=', ''); // Todas as notificações
            } else {
                $query->where('tipo', 0) // Notificações com tipo igual a 0
                    ->orWhere('tipo', $user->id); // Notificações com tipo igual ao ID do usuário logado
            }
        })->get();
        

        $user = Auth::user();
        $query = CrmSales::where('status', 'CONFIRMED');

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
        ->whereHas('list', function($query) {
            $query->where('status', 1);
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


    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
