<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TrainController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\FareController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\AvailabilityController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SslCommerzPaymentController;

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




Route::get('/', [TrainController::class, 'class']);

Route::get('/Admin', [DashboardController::class, 'index'])->name('dashboard');

Route::get('/Admin/Create_Train', [TrainController::class, 'createTrain'])->name('Create_Train');
Route::post('/Admin/Create_Train', [TrainController::class, 'storeTrain'])->name('Store_Train');
Route::get('/Admin/Show_Train', [TrainController::class, 'showTrain'])->name('Show_Train');

Route::get('/admin/create_schedule/{train_id}', [ScheduleController::class, 'createSchedule'])->name('create_schedule');
Route::post('/admin/store_schedule', [ScheduleController::class, 'storeSchedule'])->name('store_schedule');
Route::get('/admin/Show_Schedule', [ScheduleController::class, 'showSchedule'])->name('Show_Schedule');


Route::put('update_schedule/{train_id}', [ScheduleController::class, 'updatesc'])->name('update_schedule');

Route::get('/Admin/Train_Details/{id}', [TrainController::class, 'trainDetails'])->name('train_details');

Route::put('/update-train/{id}', [TrainController::class, 'updateTrain'])->name('update_train');
Route::delete('/delete-train/{id}', [TrainController::class, 'deleteTrain'])->name('delete_train');

Route::get('/admin/create_fare/{train_id}', [FareController::class, 'createFare'])->name('create_fare');
Route::post('/admin/store_fare', [FareController::class, 'storeFare'])->name('store_fare');
Route::get('/admin/Show_Fare', [FareController::class, 'showFare'])->name('Show_Fare');
Route::put('/admin/update_fare/{train_id}', [FareController::class, 'updateFare'])->name('update_fare'); //path er kaj nai


Route::get('/train-availability', [AvailabilityController::class, 'showAvailability'])
  //  ->middleware('auth') 
    ->name('train-availability.show');

Route::middleware(['redirect_if_authenticated'])->group(function () {
    Route::get('login', [AuthController::class, 'loginIndex']);
    Route::get('register', [AuthController::class, 'registerIndex']);
    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);
});


Route::middleware('auth')->group(function () {
    Route::get('logout', [AuthController::class, 'logout']);
});


Route::get('/download-fare-pdf', [PdfController::class, 'downloadFarePdf'])->name('download_fare_pdf');
Route::get('/generate-ticket', [PdfController::class, 'generateTicket']);

Route::get('/purchase-ticket', [TicketController::class, 'showPurchasePage'])->name('user.purchase_ticket');
Route::post('/purchase-ticket', [TicketController::class, 'processTicket'])->name('user.process_ticket');

// SSLCOMMERZ Start
Route::get('/example1', [SslCommerzPaymentController::class, 'exampleEasyCheckout']);
Route::get('/example2', [SslCommerzPaymentController::class, 'exampleHostedCheckout']);

Route::post('/pay', [SslCommerzPaymentController::class, 'index']);
Route::post('/pay-via-ajax', [SslCommerzPaymentController::class, 'payViaAjax']);

Route::post('/success', [SslCommerzPaymentController::class, 'success']);
Route::post('/fail', [SslCommerzPaymentController::class, 'fail']);
Route::post('/cancel', [SslCommerzPaymentController::class, 'cancel']);

Route::post('/ipn', [SslCommerzPaymentController::class, 'ipn']);
//SSLCOMMERZ END
