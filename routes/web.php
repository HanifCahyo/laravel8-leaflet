<?php

use App\Http\Controllers\TitikController;
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

// Route::get('/', function () {
//     return view('home');
// });

Route::get('/', [TitikController::class, 'index']);
Route::get('/maker', [TitikController::class, 'maker']);

Route::get('/titik/json', [TitikController::class, 'json']);
Route::get('/titik/lokasi/{id?}', [TitikController::class, 'lokasi']);
