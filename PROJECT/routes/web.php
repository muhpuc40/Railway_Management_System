<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TrainController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\FareController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PdfController;
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

Route::get('/Admin', function () {
    return view('admin.dashboard');
});

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



Route::get('/registration', [AuthController::class,'viewRegister'])->name('registration');
Route::post('/createUser', [AuthController::class, 'register'])->name('createUser');
Route::get('/login', [AuthController::class,'viewLogin'])->name('login');
Route::post('/checkLogin', [AuthController::class, 'login'])->name('checkLogin');




Route::get('/download-fare-pdf', [PdfController::class, 'downloadFarePdf'])->name('download_fare_pdf');