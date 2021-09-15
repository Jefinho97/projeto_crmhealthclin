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
//route::get('/orcamentos/materiais', [OrcamentoController::class, 'materiais']);
Route::post('/orcamentos', [OrcamentoController::class, 'store']);
Route::post('/orcamento/{id}', [OrcamentoController::class, 'store_']);

Route::get('/dashboard', [OrcamentoController::class, 'dashboard'])->middleware('auth');
