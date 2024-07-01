<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuarioController;

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

// Route::get('/', function () {
//     return view('login');
// });
// Route::get('/activar-doble-factor', function () {
//     return view('activar_autentificacion')->name('activar2af');
// });
Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::get('/', [UsuarioController::class ,'index'])->name('inicio');
Route::get('/activar-doble-factor', [UsuarioController::class ,'dobleFactorW'])->name('activar2af');

Route::post('/', [UsuarioController::class ,'login'])->name('login');
Route::post('/bye-bye', [UsuarioController::class ,'logout'])->name('sayonara');
Route::post('/activar-doble-factor', [UsuarioController::class ,'activar2AF'])->name('activar2AF');
Route::post('/validar-doble-factor', [UsuarioController::class ,'validar2AF'])->name('validar2AF');