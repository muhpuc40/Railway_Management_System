<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TrainController;
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

// Route to show the train creation form
Route::get('/Admin/Create_Train', [TrainController::class, 'createt'])->name('Create_Train');

// Route to handle the train creation form submission
Route::post('/Admin/Create_Train', [TrainController::class, 'storeTrain'])->name('Create_Train');

// Route to show the route creation form
Route::get('/Admin/Create_Route', [TrainController::class, 'creater'])->name('Create_Route');

// Route to handle the route creation form submission
Route::post('/Admin/Create_Route', [TrainController::class, 'create_route'])->name('Create_Route');
