<?php

use App\Http\Controllers\ApiConsultaGratisController;
use App\Http\Controllers\ApiCrmSalesController;
use App\Http\Controllers\ApiGeraLinkController;
use App\Http\Controllers\ApiListaExcelController;
use App\Http\Controllers\AsaasController;
use App\Http\Controllers\ContratoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/geraLink/{id}',[ ApiGeraLinkController::class ,'geraLink'])->name('geraLink');
Route::post('/geraPagamento', [AsaasController::class, 'geraPagamento'])->name('geraLink');
Route::post('/geraPagamentoConsulta', [AsaasController::class, 'geraPagamentoConsulta'])->name('geraPagamentoConsulta');
Route::post('/webhook', [AsaasController::class, 'webhook'])->name('webhook')->name('webhook');
Route::put('/crm-sales/{id}', [ApiCrmSalesController::class, 'updateCrmSales'])->name('updateCrmSales');
Route::post('/consultaGratis', [ApiConsultaGratisController::class, 'ConsultaGratis'])->name('ConsultaGratis');
Route::post('listaExcel', [ApiListaExcelController::class, 'listaExcel'])->name('listaExcel');
Route::post('geraContrato', [ContratoController::class, 'index'])->name('geraContrato');
Route::post('assas', [AssasController::class, 'receberPagamento'])->name('assas.receberPagamento');

