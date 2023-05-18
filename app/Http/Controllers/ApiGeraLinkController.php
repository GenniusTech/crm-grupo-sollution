<?php

namespace App\Http\Controllers;

use App\Models\CrmSales;
use Illuminate\Http\Request;

class ApiGeraLinkController extends Controller
{
    public function geraLink(Request $request, $id)
    {
        // Obtém os campos enviados na solicitação POST
        $linkPay = $request->input('LINK_PAY');
        $status = $request->input('STATUS');

        // Atualiza o registro correspondente na tabela crm_sales
        $venda = CrmSales::find($id);
        if ($venda) {
            $venda->link_pay = $linkPay;
            $venda->status = $status;
            $venda->save();
            return response()->json(['message' => 'atualizado com sucesso']);
        } else {
            return response()->json(['message' => 'Venda não encontrada'], 404);
        }
    }
}
