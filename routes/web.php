<?php

use App\Http\Controllers\AsaasController;
use App\Http\Controllers\CpfcnpjController;
use App\Http\Controllers\CursoLimpaNomeController;
use App\Http\Controllers\DashController;
use App\Http\Controllers\ListController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\NotificacaoController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ContratoController;
use Illuminate\Support\Facades\Route;


Route::get('/', [LoginController::class, 'index'])->name('login');
Route::post('/', [LoginController::class, 'login_action'])->name('login_action');

Route::get('/forgot-password', [RegisterController::class, 'register'])->name('register');
Route::post('/forgot-password', [RegisterController::class, 'register_action'])->name('register_action');
Route::view('/contrato', 'relatorio.contrato')->name('relatorio.contrato');

Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', [DashController::class, 'dashboard'])->name('dashboard');
    Route::get('/logout', [DashController::class, 'logout'])->name('logout');
    Route::post('/download/{id}', [DashController::class, 'downloadArquivo'])->name('download.arquivo');


    Route::get('/lista', [ListController::class, 'list'])->name('list');
    Route::post('/cadastroList', [ListController::class, 'cadastroList'])->name('cadastroList');
    Route::post('/ativar-lista/{id}', [ListController::class,'ativarLista'])->name('ativar-lista');
    Route::delete('/notificacao/{id}', [NotificacaoController::class, 'destroy'])->name('notificacao.destroy');
    Route::post('/GerarConsultas{id}', [ListController::class, 'GerarConsultas'])->name('GerarConsultas');

    Route::get('/sales/export/{id_lista}',[ListController::class, 'export'])->name('sales.export');


    Route::post('/cadastroNotficacao', [NotificacaoController::class, 'cadastroNotficacao'])->name('cadastroNotficacao');

    Route::get('/cpfcnpj', [CpfcnpjController::class, 'cpfcnpj'])->name('cpfcnpj');
    Route::get('/consulta_gratis', [CpfcnpjController::class, 'consulta_gratis'])->name('consulta_gratis');
    Route::post('/cadastroCpfCnpj', [CpfcnpjController::class, 'cadastroCpfCnpj'])->name('cadastroCpfCnpj');

    Route::get('/cursoLimpaNome',[CursoLimpaNomeController::class, 'cursoLimpaNome'])->name('cursoLimpaNome');

    Route::get('/perfil',[PerfilController::class, 'perfil'])->name('perfil');
    Route::post('/user/update', [PerfilController::class, 'update'])->name('update');
    Route::post('/perfilimg', [PerfilController::class, 'perfilimg'])->name('perfilimg');

    Route::post('geraContrato', [ContratoController::class, 'index'])->name('geraContrato');

});
