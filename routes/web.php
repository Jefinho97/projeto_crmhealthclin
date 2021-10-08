<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
use App\Http\Controllers\OrcamentoController;
use App\Http\Controllers\DiariaController;
use App\Http\Controllers\EquipeController;
use App\Http\Controllers\MaterialController;
use App\Models\Orcamento;

/** Rotas Orçamento */

Route::get('/dashboard', [OrcamentoController::class, 'dashboard'])->middleware('auth');
Route::post('/dashboard/ordem/{ordem}', [OrcamentoController::class, 'ordem'])->middleware('auth');

Route::get('/', [OrcamentoController::class, 'index']);
Route::get('/orcamentos/create', [OrcamentoController::class, 'create'])->middleware('auth');
Route::post('/orcamentos', [OrcamentoController::class, 'store']);
Route::post('/orcamentos/2', [OrcamentoController::class, 'store2']);
Route::get('/orcamentos/{id}', [OrcamentoController::class, 'show']);
Route::delete('/orcamentos/{id}', [OrcamentoController::class, 'destroy'])->middleware('auth');
Route::get('/orcamentos/edit/{id}', [OrcamentoController::class, 'edit'])->middleware('auth');
Route::put('/orcamentos/update/{id}', [OrcamentoController::class, 'update'])->middleware('auth');
Route::put('/orcamentos/status/{id}', [OrcamentoController::class, 'status'])->middleware('auth');
Route::put('/orcamentos/razao_status/{id}', [OrcamentoController::class, 'razao_status'])->middleware('auth');

/** Rotas Diarias */
Route::get('/diarias/create', [DiariaController::class, 'create'])->middleware('auth');
Route::post('/diarias', [DiariaController::class, 'store'])->middleware('auth');
Route::delete('/diarias/{id}', [DiariaController::class, 'destroy'])->middleware('auth');
Route::get('/diarias/dashboard', [DiariaController::class, 'dashboard'])->middleware('auth');
Route::get('/diarias/edit/{id}', [DiariaController::class, 'edit'])->middleware('auth');
Route::put('/diarias/update/{id}', [DiariaController::class, 'update'])->middleware('auth');

/** Rotas Equipes */
Route::get('/equipes/create', [EquipeController::class, 'create'])->middleware('auth');
Route::post('/equipes', [EquipeController::class, 'store'])->middleware('auth');
Route::delete('/equipes/{id}', [EquipeController::class, 'destroy'])->middleware('auth');
Route::get('/equipes/dashboard', [EquipeController::class, 'dashboard'])->middleware('auth');
Route::get('/equipes/edit/{id}', [EquipeController::class, 'edit'])->middleware('auth');
Route::put('/equipes/update/{id}', [EquipeController::class, 'update'])->middleware('auth');

/** Rotas Materiais */
Route::get('/materiais/create', [MaterialController::class, 'create'])->middleware('auth');
Route::post('/materiais', [MaterialController::class, 'store'])->middleware('auth');
Route::delete('/materiais/{id}', [MaterialController::class, 'destroy'])->middleware('auth');
Route::get('/materiais/dashboard', [MaterialController::class, 'dashboard'])->middleware('auth');
Route::get('/materiais/edit/{id}', [MaterialController::class, 'edit'])->middleware('auth');
Route::put('/materiais/update/{id}', [MaterialController::class, 'update'])->middleware('auth');



