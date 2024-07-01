<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TrainController;
use App\Http\Controllers\RouteController;
use App\Http\Controllers\HomeController;

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

Route::get('/', function () {
    return view('home');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::get('/Admin/Create_Train', [TrainController::class, 'createTrain'])->name('Create_Train');
Route::post('/Admin/Create_Train', [TrainController::class, 'storeTrain'])->name('Create_Train');
Route::get('/Admin/Show_Train', [TrainController::class, 'showTrain'])->name('Show_Train');


Route::get('/Admin/Create_Route', [RouteController::class, 'createRoute'])->name('Create_Route');
Route::post('/Admin/Create_Route', [RouteController::class, 'storeRoute'])->name('Create_Route');
Route::get('/Admin/Show_Route', [RouteController::class, 'showRoute'])->name('Show_Route');

