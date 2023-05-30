<?php

namespace App\Http\Controllers;

use App\Models\CrmSales;
use App\Models\User;
use Dotenv\Validator;
use Illuminate\Http\Request;

class ListaExcelController extends Controller
{
 
    public function listaExcel(Request $request)
    {
        $id_lista = $request->input('id_lista');
        $id_user = $request->input('id_user');
        
        $isAdmin = User::where('id', $id_user)
            ->where('profile', 'admin')
            ->exists();
    
        $sales = CrmSales::where('id_lista', $id_lista);
    
        if ($isAdmin) {
            $sales->where(function ($query) {
                $query->where('status', 'PAYMENT_RECEIVED')
                    ->orWhere('status', 'PAYMENT_CONFIRMED');
            });
        } else {
            $sales->where('id_user', $id_user)
                ->where(function ($query) {
                    $query->where('status', 'PAYMENT_RECEIVED')
                        ->orWhere('status', 'PAYMENT_CONFIRMED');
                });
        }
    
        $result = $sales->get();
    
        return response()->json($result);
    }
    
    
    
    
    
    

}

        // $id_lista = $request->input('id_lista');
        // $id_user = $request->input('id_user');
    
//         $query = CrmSales::query()
//             ->where('id_lista', $id_lista)
//             ->whereIn('status', ['PAYMENT_RECEIVED', 'PAYMENT_CONFIRMED']);
    
//         $user = User::find('id',$id_user);
    
//         if ($user && $user->profile == 'admin') {
//             $query->where('id_lista', $id_lista);
//         } else {
//             $query->where('id_user', $id_user);
//         }
    
//         $result = $query->get();
    
//         return response()->json($result);
//     }

// }
