<?php

use App\Http\Controllers\ApiGeraLinkController;
use App\Http\Controllers\AsaasController;
use App\Http\Controllers\ListaExcelController;
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
Route::post('/webhook', [AsaasController::class, 'webhook'])->name('webhook');
Route::post('listaExcel', [ListaExcelController::class, 'listaExcel'])->name('listaExcel');



