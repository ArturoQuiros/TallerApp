<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ClientController;
use App\Http\Controllers\WorkorderStateController;
use App\Http\Controllers\PieceController;
use App\Http\Controllers\WorkorderController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\RegisteredUserController;

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

Route::get('/', function () {
    //return view('welcome');
    return view('auth/login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');


require __DIR__.'/auth.php';

Route::group(['middleware' => ['auth']], function () {
    //only authenticated users can access these routes 

    Route::get('/clients', [ClientController::class, 'index'])->name('clients');
    Route::get('/clients/create', [ClientController::class, 'create']);
    Route::get('/clients/{id}/edit', [ClientController::class, 'edit']);
    Route::get('/clients/{id}/delete', [ClientController::class, 'delete']);
    Route::post('/clients', [ClientController::class, 'store']);
    Route::put('/clients/{id}', [ClientController::class, 'update']);
    Route::delete('/clients/{id}', [ClientController::class, 'destroy']);

    Route::get('/workorderstates', [WorkorderStateController::class, 'index'])->name('workorderstates');
    Route::get('/workorderstates/create', [WorkorderStateController::class, 'create']);
    Route::get('/workorderstates/{id}/edit', [WorkorderStateController::class, 'edit']);
    Route::get('/workorderstates/{id}/delete', [WorkorderStateController::class, 'delete']);
    Route::post('/workorderstates', [WorkorderStateController::class, 'store']);
    Route::put('/workorderstates/{id}', [WorkorderStateController::class, 'update']);
    Route::delete('/workorderstates/{id}', [WorkorderStateController::class, 'destroy']);

    Route::get('/pieces', [PieceController::class, 'index'])->name('pieces');
    Route::get('/pieces/create', [PieceController::class, 'create']);
    Route::get('/pieces/{id}/edit', [PieceController::class, 'edit']);
    Route::get('/pieces/{id}/delete', [PieceController::class, 'delete']);
    Route::post('/pieces', [PieceController::class, 'store']);
    Route::put('/pieces/{id}', [PieceController::class, 'update']);
    Route::delete('/pieces/{id}', [PieceController::class, 'destroy']);

    Route::get('/workorders', [WorkorderController::class, 'index'])->name('workorders');
    Route::get('/workorders/create', [WorkorderController::class, 'create']);
    Route::get('/workorders/{id}/edit', [WorkorderController::class, 'edit']);
    Route::get('/workorders/{id}/delete', [WorkorderController::class, 'delete']);
    Route::post('/workorders', [WorkorderController::class, 'store']);
    Route::put('/workorders/{id}', [WorkorderController::class, 'update']);
    Route::delete('/workorders/{id}', [WorkorderController::class, 'destroy']);

    Route::get('/workorders/{id}/pieces_list', [WorkorderController::class, 'pieces_list']);
    Route::post('/workorders/{id}/pieces_list', [WorkorderController::class, 'pieces_list']);
    Route::delete('/workorders/{workorder_id}/pieces_list/{id}', [WorkorderController::class, 'removePiece']);

    Route::get('/workorders/{id}/photos_list', [WorkorderController::class, 'photos_list']);
    Route::post('/workorders/{id}/photos_list', [WorkorderController::class, 'photos_list']);
    Route::delete('/workorders/{workorder_id}/photos_list/{id}', [WorkorderController::class, 'removePhoto']);

    Route::get('/workorders/{id}/signature', [WorkorderController::class, 'signature']);
    Route::post('/workorders/{id}/signature', [WorkorderController::class, 'signature']);

    Route::get('/workorders/{id}/export_pdf', [WorkorderController::class, 'generatePDF']);
  
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/users', [UserController::class, 'index'])->name('users');
    Route::get('/users/{id}/edit', [UserController::class, 'edit']);
    Route::put('/users/{id}', [UserController::class, 'update']);

    Route::get('register', [RegisteredUserController::class, 'create'])
                ->name('register');

    Route::post('register', [RegisteredUserController::class, 'store']);

    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

});