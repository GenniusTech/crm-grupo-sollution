<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use GuzzleHttp\Client;

use App\Models\CrmSales;
use App\Models\User;

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
        $response = $client->post('https://sandbox.asaas.com/api/v3/customers', $options);
        $body = (string) $response->getBody();
        $data = json_decode($body, true);
        if ($response->getStatusCode() === 200) {
            $customerId = $data['id'];
            $options['json'] = [
                'customer' => $customerId,
                'billingType' => 'UNDEFINED',
                'value' => 375,
                'dueDate' => $request->input('dataFormatada'),
                'description' => 'Limpa Nome',
            ];
            $response = $client->post('https://sandbox.asaas.com/api/v3/payments', $options);
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

    public function geraPagamentoConsulta(Request $request)
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
        $response = $client->post('https://sandbox.asaas.com/api/v3/customers', $options);
        $body = (string) $response->getBody();
        $data = json_decode($body, true);
        if ($response->getStatusCode() === 200) {
            $customerId = $data['id'];
            $options['json'] = [
                'customer' => $customerId,
                'billingType' => 'PIX',
                'value' => 29.99,
                'dueDate' => $request->input('dataFormatada'),
                'description' => 'Consulta CPF/CNPJ',
            ];
            $response = $client->post('https://sandbox.asaas.com/api/v3/payments', $options);
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

    public function receberPagamento(Request $request)
    {
        // Obtenha os dados do JSON recebido
        $jsonData = $request->json()->all();

        // Verifique se o evento é PAYMENT_CONFIRMED
        if ($jsonData['event'] === 'PAYMENT_CONFIRMED') {
            // Obtenha o ID da requisição
            $idRequisicao = $jsonData['payment']['id'];


            // Consulta à tabela crm_sales para obter o nome do usuário e o CPF
            $crmSale = CrmSales::where('id_pay_limpa', $idRequisicao)->first();
            if ($crmSale) {
                $idUsuario = $crmSale->id_user;

                // Atualizar o campo status_limpanome para PAYMENT_CONFIRMED na tabela crm_sales
                $crmSale->status_limpanome = 'PAYMENT_CONFIRMED';
                $crmSale->save();

                // Consulta à tabela users para obter o CPF
                $user = User::where('id', $idUsuario)->first();
                if ($user) {
                    $cpf = $user->cpf;

                    // Dados para enviar na requisição POST
                    $dados = [
                        'cpf' => $cpf,
                        'value' => 375,
                        'description' => 'One Motos',
                        'product' => 2
                    ];

                    // Enviar a requisição POST para oneclube.com.br/recebe
                    $client = new Client();
                    $response = $client->post('https://homolologacao.oneclube.com.br/confirm-sale-product', [
                        'form_params' => $dados
                    ]);

                    // Verificar se a requisição teve sucesso
                    if ($response->getStatusCode() === 200) {
                        // Retornar true em caso de sucesso
                        return response()->json(['status' => 'success', 'response' => true]);
                    }
                }
            }
        }

        // Caso contrário, retorne uma resposta de erro
        return response()->json(['status' => 'error', 'message' => 'Evento não suportado']);
    }

}
