<?php

namespace App\Http\Controllers;

use App\Models\CrmList;
use App\Models\CrmSales;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\Session\Session;
use Illuminate\Support\Facades\Auth;

class ApiConsultaGratisController extends Controller
{
    public function ConsultaGratis(Request $request)
    {
        try {
            $request->validate([
                'cpfcnpj'           => 'required',
                'cliente'           => 'required',
                'situacao'          => 'required',
                'dataNascimento'    => 'required',
                'email'             => 'required|email',
                'telefone'          => 'required',
                'id_user'           => 'required'
            ]);

            $lista = CrmList::where('status', '=', 1)->firstOrFail();

            //Criar um novo registro no CRM_Sales
            $crmSales = new CrmSales();
            $crmSales->cpfcnpj          = $request->input('cpfcnpj');
            $crmSales->cliente          = $request->input('cliente');
            $crmSales->situacao         = $request->input('situacao');
            $crmSales->dataNascimento   = date('Y-m-d', strtotime($request->input('dataNascimento')));
            $crmSales->email            = $request->input('email');
            $crmSales->telefone         = $request->input('telefone');
            $crmSales->id_lista         = $lista->id;
            $crmSales->id_user          = $request->input('id_user');
            $crmSales->status_consulta  = "PAYMENT_CONFIRMED";
            $crmSales->status_limpanome = "PENDING";

            // Reduzir 1 de consulta_g no User
            $idUser = $request->input('id_user');
            $user = User::find($idUser);
            if (!$user) {
                throw new \Exception('Usuário não encontrado.');
            }

            if ($user->consulta_g <= 0) {
                throw new \Exception('Consultas insuficientes.');
            }

            $user->consulta_g -= 1;
            $user->save();
            $crmSales->save();
            return response()->json(['message' => 'Cadastro realizado com sucesso'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}
