<?php

use App\Http\Controllers\admin\AdminController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\admin\CinemaHallController;
use App\Http\Controllers\client\CinemaHallController as ClientCinemaHallController;
use App\Http\Controllers\admin\MovieController;
use App\Http\Controllers\admin\ScreeningController;
use App\Http\Controllers\admin\SeatController;
use App\Http\Controllers\client\SeatController as ClientSeatController;
use App\Http\Controllers\client\ClientController;
use App\Http\Controllers\client\TicketController;
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
    Route::post('/create-hall', [CinemaHallController::class, 'createHall'])->name('add_hall');
    Route::delete('/{id}/delete-hall', [CinemaHallController::class, 'deleteHall'])->name('delete_hall');

    Route::post('/create-hall-detail', [CinemaHallController::class, 'createHallDetail'])->name('add_hall_detail');
    Route::post('/{id}/create-seats', [SeatController::class, 'createSeats'])->name('add_seats');
    Route::post('/{id}/set-current-hall', [CinemaHallController::class, 'setCurrentHall'])->name('set_current_hall');

    Route::post('/{id}/set-price', [SeatController::class, 'setPrice'])->name('set_price');

    Route::post('/create-movie', [MovieController::class, 'createMovie'])->name('add_movie');
    Route::post('/create-screening', [ScreeningController::class, 'createScreening'])->name('add_screening');

    Route::get('/delete-screening', [ScreeningController::class, 'deleteScreening'])->name('delete_screening');

    Route::post('/open-sells', [AdminController::class, 'openSells'])->name('open_sells');
});

Route::prefix('/client-panel')->group(function () {
    Route::get('/', [ClientController::class, 'index'])->name('get_client_info');
    Route::get('/hall/{id}', [ClientCinemaHallController::class, 'getHall'])->name('get_hall');
    Route::get('/ticket', [TicketController::class, 'getTicket'])->name('get_ticket');
    Route::get('/payment', [TicketController::class, 'getPayment'])->name('get_payment');
    Route::post('/choose-seats', [ClientSeatController::class, 'chooseSeats'])->name('choose_seats');
});
