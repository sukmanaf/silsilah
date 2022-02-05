<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SilsilahController;
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


// Route::resource('/', SilsilahController::class);
Route::get('/', [SilsilahController::class ,'index']);
Route::get('/get', [SilsilahController::class ,'get']);
Route::get('/tree', [SilsilahController::class ,'tree']);
Route::get('/trees', [SilsilahController::class ,'trees']);
Route::get('/api', [SilsilahController::class ,'api']);
Route::get('/getnama', [SilsilahController::class ,'getnama']);
Route::post('/store', [SilsilahController::class ,'store']);
Route::get('/edit/{id}', [SilsilahController::class ,'edit']);
Route::post('/update/{id}', [SilsilahController::class ,'update']);
Route::get('/destroy/{id}', [SilsilahController::class ,'destroy']);
// Route::resource('/silsilah', SilsilahController::class);
