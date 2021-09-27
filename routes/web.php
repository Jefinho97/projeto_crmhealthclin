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

Route::get('/dashboard', [OrcamentoController::class, 'dashboard'])->middleware('auth');

Route::get('/', [OrcamentoController::class, 'index']);
Route::get('/orcamentos/create', [OrcamentoController::class, 'create'])->middleware('auth');
Route::post('/orcamentos', [OrcamentoController::class, 'store']);
Route::post('/orcamentos/2', [OrcamentoController::class, 'store2']);
Route::get('/orcamentos/{id}', [OrcamentoController::class, 'show']);
Route::delete('/orcamentos/{id}', [OrcamentoController::class, 'destroy'])->middleware('auth');

Route::get('/diarias/create', [DiariaController::class, 'create'])->middleware('auth');
Route::post('/diarias', [DiariaController::class, 'store'])->middleware('auth');
Route::delete('/diarias/{id}', [DiariaController::class, 'destroy'])->middleware('auth');

Route::get('/equipes/create', [EquipeController::class, 'create'])->middleware('auth');
Route::post('/equipes', [EquipeController::class, 'store'])->middleware('auth');
Route::delete('/equipes/{id}', [EquipeController::class, 'destroy'])->middleware('auth');

Route::get('/materials/create', [MaterialController::class, 'create'])->middleware('auth');
Route::post('/materials', [MaterialController::class, 'store'])->middleware('auth');
Route::delete('/materials/{id}', [MaterialController::class, 'destroy'])->middleware('auth');



