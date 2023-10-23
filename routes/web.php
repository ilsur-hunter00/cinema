<?php

use App\Http\Controllers\admin\AdminController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

//Route::get('/', function () {
//    return view('welcome');
//});

Route::prefix('/admin-panel')->group(function () {
    Route::get('/', [AdminController::class, 'index']);
    Route::post('/create-hall', [AdminController::class, 'createHall'])->name('add_hall');
    Route::get('/{id}/delete-hall', [AdminController::class, 'deleteHall'])->name('delete_hall');

    Route::post('/create-hall-detail', [AdminController::class, 'createHallDetail'])->name('add_hall_detail');
    Route::post('/{id}/create-seats', [AdminController::class, 'createSeats'])->name('add_seats');
});
