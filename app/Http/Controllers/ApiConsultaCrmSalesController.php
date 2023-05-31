<?php

namespace App\Http\Controllers;

use App\Models\CrmSales;
use Illuminate\Http\Request;

class ApiCrmSalesController extends Controller
{
    public function updateCrmSales(Request $request, $id)
    {
        $crmSales = CrmSales::find($id);

        if (!$crmSales) {
            return response()->json(['error' => 'Atualização não realizada'], 404);
        }

        $crmSales->link_pay_consulta = $request->input('link_pay_consulta');
        $crmSales->id_pay_consulta = $request->input('id_pay_consulta');
        $crmSales->status_consulta = $request->input('status_consulta');
        $crmSales->save();

        return response()->json(['message' => 'CrmSales updated successfully']);
    }
}
