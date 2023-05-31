<?php

namespace App\Http\Controllers;

use App\Models\CrmSales;
use App\Models\User;
use Illuminate\Http\Request;

class ApiListaExcelController extends Controller
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
