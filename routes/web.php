<?php

use App\Http\Controllers\admin\AdminController;
use App\Http\Controllers\Admin\AuthController;
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

Route::get('/admin-panel/login', [AuthController::class, 'show'])->name('show_login');
Route::post('/admin-panel/login', [AuthController::class, 'login'])->name('admin_login');

Route::prefix('/admin-panel')->middleware('auth')->group(function () {
    Route::get('/', [AdminController::class, 'index']);
    Route::post('/create-hall', [AdminController::class, 'createHall'])->name('add_hall');
    Route::delete('/{id}/delete-hall', [AdminController::class, 'deleteHall'])->name('delete_hall');

    Route::post('/create-hall-detail', [AdminController::class, 'createHallDetail'])->name('add_hall_detail');
    Route::post('/{id}/create-seats', [AdminController::class, 'createSeats'])->name('add_seats');
    Route::post('/{id}/set-current-hall', [AdminController::class, 'setCurrentHall'])->name('set_current_hall');

    Route::post('/{id}/set-price', [AdminController::class, 'setPrice'])->name('set_price');

    Route::post('/create-movie', [AdminController::class, 'createMovie'])->name('add_movie');
    Route::post('/create-screening', [AdminController::class, 'createScreening'])->name('add_screening');

    Route::get('/delete-screening', [AdminController::class, 'deleteScreening'])->name('delete_screening');

    Route::post('/open-sells', [AdminController::class, 'openSells'])->name('open_sells');
});

Route::prefix('/user-panel')->middleware('auth')->group(function () {

});
