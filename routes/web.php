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

Route::get('/', [OrcamentoController::class, 'index']);
Route::get('/orcamentos/create', [OrcamentoController::class, 'create'])->middleware('auth');
Route::get('/orcamentos/create/equipe', [OrcamentoController:: class, 'create_equipe']);
Route::get('/dashboard', [OrcamentoController::class, 'dashboard'])->middleware('auth');
Route::get('/orcamentos/{id}', [EventController::class, 'show']);

Route::post('/orcamentos', [OrcamentoController::class, 'store']);
Route::post('/orcamentos/equipe', [OrcamentoController::class, 'store_equipe']);
