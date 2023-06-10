<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use GuzzleHttp\Client;

use App\Models\CrmSales;

class AsaasController extends Controller
{
    public function geraPagamento(Request $request)
    {
        $client = new Client();
        $options = [
            'headers' => [
                'Content-Type' => 'application/json',
                'access_token' => env('API_TOKEN'),
            ],
            'json' => [
                'name'      => $request->input('name'),
                'cpfCnpj'   => $request->input('cpfcnpj'),
            ],
        ];
        $response = $client->post('https://www.asaas.com/api/v3/customers', $options);
        $body = (string) $response->getBody();
        $data = json_decode($body, true);
        if ($response->getStatusCode() === 200) {
            $customerId = $data['id'];
            if($request->input('opcaoParcelas') > 1){
                $options['json'] = [
                    'customer' => $customerId,
                    'billingType' => $request->input('opcaoPagamento'),
                    'value' => 997,
                    'dueDate' => $request->input('dataFormatada'),
                    'description' => 'Limpa Nome',
                    'installmentCount' => $request->input('opcaoParcelas'),
                    'installmentValue' => $request->input('valor') / $request->input('opcaoParcelas') ,
                ];
            }else{
                $options['json'] = [
                    'customer' => $customerId,
                    'billingType' => $request->input('opcaoPagamento'),
                    'value' => 997,
                    'dueDate' => $request->input('dataFormatada'),
                    'description' => 'Limpa Nome',
                    'split' => [
                        'walletId'      => env('ID_WALLET_THIAGO'),
                        'fixedValue'    => '35.20',
                        'walletId'      => env('ID_WALLET_DIEGO'),
                        'fixedValue'    => '55',
                        'walletId'      => env('ID_WALLET_LION'),
                        'fixedValue'    => '55',
                        'walletId'      => env('ID_WALLET_JP'),
                        'fixedValue'    => '74.80',
                    ]
                ];
            }
            $response = $client->post('https://www.asaas.com/api/v3/payments', $options);
            $body = (string) $response->getBody();
            $data = json_decode($body, true);
            if ($response->getStatusCode() === 200) {

                $dados['json'] = [
                    'paymentId'     => $data['id'],
                    'customer'      => $data['customer'],
                    'paymentLink'   => $data['invoiceUrl'],
                ];

                return $dados;
            } else {
                return "Erro!";
            }
        } else {
            return "Erro!";
        }
    }

    public function webhook(Request $request)
    {
        $data = $request->json();
        $id = $data->get('payment.id');
        $status = $data->get('payment.status');

        CrmSales::where('id_pay', $id)->update(['status' => $status]);

        $file = public_path('log.txt');
        $response = ['success' => true];

        file_put_contents($file, json_encode($response));

        return response()->json($response);
    }
}
